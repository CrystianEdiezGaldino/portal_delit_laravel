<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ConteudoIead;
use App\Models\Usuario;
use App\Services\ConteudoIeadService;

class IeadController extends Controller
{
    protected $conteudoIeadService;

    public function __construct(ConteudoIeadService $conteudoIeadService)
    {
        $this->conteudoIeadService = $conteudoIeadService;
        $this->middleware('auth');
    }

    /**
     * Página inicial do IEAD
     */
    public function index()
    {
        $usuario = Auth::user();
        $pkUsuario = (new Usuario())->buscarUsuarioPorIme($usuario->ime);
        $grauUsuario = $pkUsuario ? $pkUsuario->ativo_no_grau : 0;
        
        return view('iead.index', [
            'grau_usuario' => $grauUsuario,
            'is_admin' => $usuario->role === 'admin'
        ]);
    }

    /**
     * Define o grau para exibição de conteúdo
     */
    public function setGrau(Request $request)
    {
        $grau = (int) $request->input('grau');
        $ime = Auth::user()->ime;

        if (empty($grau) || empty($ime)) {
            return response('Parâmetros inválidos', 400);
        }

        $usuario = new Usuario();
        $pkUsuario = $usuario->buscarUsuarioPorIme($ime);
        
        if (!$pkUsuario) {
            return response('Usuário não encontrado', 404);
        }

        // Verifica se o usuário tem acesso ao grau
        if ($pkUsuario->ativo_no_grau < $grau) {
            return response('Acesso negado. Você não tem permissão para visualizar esse grau.', 403);
        }

        // Busca os conteúdos do grau
        $conteudos = ConteudoIead::where('grau', $grau)->get();
        
        if ($request->ajax()) {
            return view('iead.grau', ['conteudos' => $conteudos])->render();
        }
        
        return view('iead.grau', ['conteudos' => $conteudos]);
    }

    /**
     * Gerenciar conteúdos IEAD
     */
    public function gerenciarConteudos()
    {
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        $conteudos = ConteudoIead::all();
        return view('iead.gerenciar', ['conteudos' => $conteudos]);
    }

    /**
     * Criar conteúdo IEAD
     */
    public function criarConteudo(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            // Validação básica
            $request->validate([
                'titulo' => 'required',
                'descricao' => 'required',
                'grau' => 'required|numeric',
                'tipo_conteudo' => 'required',
            ]);

            // Validação específica para vídeos
            if ($request->input('tipo_conteudo') === 'video') {
                $request->validate([
                    'video_tipo' => 'required',
                ]);

                if ($request->input('video_tipo') === 'youtube') {
                    $request->validate([
                        'youtube_url' => 'required|url'
                    ]);
                } else {
                    $request->validate([
                        'arquivo' => 'required|file|mimes:mp4|max:20480'
                    ]);
                }
            } else {
                // Validação para outros tipos de conteúdo
                $request->validate([
                    'arquivo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480'
                ]);
            }

            $dados = [
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'grau' => $request->input('grau'),
                'tipo_conteudo' => $request->input('tipo_conteudo')
            ];

            if ($request->input('tipo_conteudo') === 'video') {
                if ($request->input('video_tipo') === 'youtube') {
                    // Extrai o ID do vídeo do YouTube
                    $url = $request->input('youtube_url');
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
                    $videoId = $matches[1] ?? null;

                    if ($videoId) {
                        $dados['caminho_arquivo'] = "https://www.youtube.com/embed/{$videoId}";
                        $dados['video_tipo'] = 'youtube';
                    } else {
                        return back()->withErrors(['youtube_url' => 'URL do YouTube inválida']);
                    }
                } else {
                    // Upload de vídeo local
                    if ($request->hasFile('arquivo')) {
                        $arquivo = $request->file('arquivo');
                        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                        
                        if (!file_exists(public_path('uploads/iead'))) {
                            mkdir(public_path('uploads/iead'), 0777, true);
                        }
                        
                        $arquivo->move(public_path('uploads/iead'), $nomeArquivo);
                        $dados['caminho_arquivo'] = '/uploads/iead/' . $nomeArquivo;
                        $dados['video_tipo'] = 'local';
                    } else {
                        return back()->withErrors(['arquivo' => 'O arquivo de vídeo é obrigatório']);
                    }
                }
            } else {
                // Upload de outros tipos de arquivo
                if ($request->hasFile('arquivo')) {
                    $arquivo = $request->file('arquivo');
                    $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                    
                    if (!file_exists(public_path('uploads/iead'))) {
                        mkdir(public_path('uploads/iead'), 0777, true);
                    }
                    
                    $arquivo->move(public_path('uploads/iead'), $nomeArquivo);
                    $dados['caminho_arquivo'] = '/uploads/iead/' . $nomeArquivo;
                } else {
                    return back()->withErrors(['arquivo' => 'O arquivo é obrigatório']);
                }
            }

            try {
                ConteudoIead::create($dados);
                return redirect()->route('gerenciar.conteudos.iead')->with('success', 'Conteúdo salvo com sucesso!');
            } catch (\Exception $e) {
                \Log::error('Erro ao salvar conteúdo: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Erro ao salvar o conteúdo. Por favor, tente novamente.']);
            }
        }

        return view('iead.form');
    }

    /**
     * Editar conteúdo IEAD
     */
    public function editarConteudo($id, Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'titulo' => 'required',
                'descricao' => 'required',
                'grau' => 'required|numeric',
                'tipo_conteudo' => 'required',
                'arquivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:20480',
                'video_tipo' => 'required_if:tipo_conteudo,video',
                'youtube_url' => 'required_if:video_tipo,youtube|url'
            ]);

            $dados = $request->only(['titulo', 'descricao', 'grau', 'tipo_conteudo']);
            
            if ($request->input('tipo_conteudo') === 'video') {
                if ($request->input('video_tipo') === 'youtube') {
                    // Extrai o ID do vídeo do YouTube
                    $url = $request->input('youtube_url');
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
                    $videoId = $matches[1] ?? null;

                    if ($videoId) {
                        $dados['caminho_arquivo'] = "https://www.youtube.com/embed/{$videoId}";
                        $dados['video_tipo'] = 'youtube';
                    } else {
                        return back()->withErrors(['youtube_url' => 'URL do YouTube inválida']);
                    }
                } else {
                    // Upload de vídeo local
                    if ($request->hasFile('arquivo')) {
                        $arquivo = $request->file('arquivo');
                        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                        
                        if (!file_exists(public_path('uploads/iead'))) {
                            mkdir(public_path('uploads/iead'), 0777, true);
                        }
                        
                        $arquivo->move(public_path('uploads/iead'), $nomeArquivo);
                        $dados['caminho_arquivo'] = '/uploads/iead/' . $nomeArquivo;
                        $dados['video_tipo'] = 'local';
                        
                        // Se já existia um arquivo anterior, tenta removê-lo
                        $conteudoAntigo = ConteudoIead::find($id);
                        if ($conteudoAntigo && file_exists(public_path($conteudoAntigo->caminho_arquivo))) {
                            unlink(public_path($conteudoAntigo->caminho_arquivo));
                        }
                    }
                }
            } else {
                // Upload de outros tipos de arquivo
                if ($request->hasFile('arquivo')) {
                    $arquivo = $request->file('arquivo');
                    $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                    
                    if (!file_exists(public_path('uploads/iead'))) {
                        mkdir(public_path('uploads/iead'), 0777, true);
                    }
                    
                    $arquivo->move(public_path('uploads/iead'), $nomeArquivo);
                    $dados['caminho_arquivo'] = '/uploads/iead/' . $nomeArquivo;
                    
                    // Se já existia um arquivo anterior, tenta removê-lo
                    $conteudoAntigo = ConteudoIead::find($id);
                    if ($conteudoAntigo && file_exists(public_path($conteudoAntigo->caminho_arquivo))) {
                        unlink(public_path($conteudoAntigo->caminho_arquivo));
                    }
                }
            }

            ConteudoIead::find($id)->update($dados);
            
            return redirect()->route('gerenciar.conteudos.iead')->with('success', 'Conteúdo atualizado com sucesso!');
        }

        $conteudo = ConteudoIead::findOrFail($id);
        return view('iead.form', ['conteudo' => $conteudo]);
    }

    /**
     * Deletar conteúdo IEAD
     */
    public function deletarConteudo($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(404);
        }
        
        $conteudo = ConteudoIead::find($id);
        
        if ($conteudo) {
            // Remove o arquivo físico se existir
            if (file_exists(public_path($conteudo->caminho_arquivo))) {
                unlink(public_path($conteudo->caminho_arquivo));
            }
            
            $conteudo->delete();
        }
        
        return redirect()->route('gerenciar.conteudos.iead')->with('success', 'Conteúdo excluído com sucesso!');
    }

    /**
     * Servir vídeo com suporte a streaming
     */
    public function servirVideo($id)
    {
        $conteudo = ConteudoIead::findOrFail($id);
        
        if ($conteudo->tipo_conteudo !== 'video') {
            abort(404);
        }
        
        $ime = Auth::user()->ime;
        $temAcesso = Usuario::where('ime', $ime)
                          ->where('grau', '>=', $conteudo->grau)
                          ->exists();
        
        if (!$temAcesso) {
            abort(404);
        }
        
        $caminhoArquivo = public_path($conteudo->caminho_arquivo);
        
        if (!file_exists($caminhoArquivo)) {
            abort(404);
        }
        
        $size = filesize($caminhoArquivo);
        $start = 0;
        $end = $size - 1;
        
        header('Content-Type: video/mp4');
        header('Accept-Ranges: bytes');
        
        if (isset($_SERVER['HTTP_RANGE'])) {
            $c_start = $start;
            $c_end = $end;
            
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            
            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
            }
            
            $c_end = ($c_end > $end) ? $end : $c_end;
            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            
            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1;
            header('HTTP/1.1 206 Partial Content');
        }
        
        header("Content-Range: bytes $start-$end/$size");
        header('Content-Length: ' . $length);
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        
        $buffer = 1024 * 8;
        $fp = fopen($caminhoArquivo, 'rb');
        fseek($fp, $start);
        
        while (!feof($fp) && ($p = ftell($fp)) <= $end) {
            if ($p + $buffer > $end) {
                $buffer = $end - $p + 1;
            }
            echo fread($fp, $buffer);
            flush();
        }
        
        fclose($fp);
        exit;
    }
}