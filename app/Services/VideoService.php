<?php

namespace App\Services;

use App\Models\ConteudoIead;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    protected $conteudo;

    public function __construct(ConteudoIead $conteudo)
    {
        $this->conteudo = $conteudo;
    }

    public function servirVideo($id, $grauUsuario)
    {
        try {
            $conteudo = $this->conteudo->findOrFail($id);
            
            if ($conteudo->tipo_conteudo !== 'video') {
                throw new \Exception('Este conteúdo não é um vídeo');
            }
            
            if ($grauUsuario < $conteudo->grau) {
                throw new \Exception('Acesso negado. Você não tem permissão para acessar este vídeo');
            }
            
            $caminhoArquivo = storage_path('app/public/' . str_replace('storage/', '', $conteudo->caminho_arquivo));
            
            if (!file_exists($caminhoArquivo)) {
                throw new \Exception('Arquivo de vídeo não encontrado');
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
        } catch (\Exception $e) {
            \Log::error('Erro ao servir vídeo: ' . $e->getMessage());
            throw $e;
        }
    }
} 