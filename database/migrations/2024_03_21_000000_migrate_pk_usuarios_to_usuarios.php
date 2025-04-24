<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MigratePkUsuariosToUsuarios extends Migration
{
    public function up()
    {
        // Busca todos os registros da tabela pk_usuarios
        $pkUsuarios = DB::table('pk_usuarios')->get();

        foreach ($pkUsuarios as $pkUsuario) {
            // Verifica se o usuário já existe na tabela usuarios
            $usuarioExistente = DB::table('usuarios')
                ->where('ime', $pkUsuario->ime_num)
                ->first();

            // Gera um email temporário se não houver email
            $email = $pkUsuario->email;
            if (empty($email)) {
                $email = 'temp_' . str_replace('.', '_', $pkUsuario->ime_num) . '@temp.com';
            }

            if (!$usuarioExistente) {
                // Cria um novo usuário com os dados do pk_usuario
                DB::table('usuarios')->insert([
                    'ime' => $pkUsuario->ime_num ?? '',
                    'nome' => $pkUsuario->cadastro ?? 'Sem Nome',
                    'email' => $email,
                    'senha' => Hash::make('senha123'), // Senha padrão temporária
                    'role' => 'usuario',
                    'status' => 'ativo',
                    'grau' => $pkUsuario->ativo_no_grau ?? 1,
                    'cpf' => $pkUsuario->cic ?? '',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                // Atualiza o usuário existente com os dados do pk_usuario
                DB::table('usuarios')
                    ->where('ime', $pkUsuario->ime_num)
                    ->update([
                        'nome' => $pkUsuario->cadastro ?? $usuarioExistente->nome,
                        'email' => !empty($pkUsuario->email) ? $pkUsuario->email : $usuarioExistente->email,
                        'grau' => $pkUsuario->ativo_no_grau ?? $usuarioExistente->grau,
                        'cpf' => !empty($pkUsuario->cic) ? $pkUsuario->cic : $usuarioExistente->cpf,
                        'updated_at' => now()
                    ]);
            }
        }
    }

    public function down()
    {
        // Não é necessário fazer rollback pois os dados originais permanecem na tabela pk_usuarios
    }
} 