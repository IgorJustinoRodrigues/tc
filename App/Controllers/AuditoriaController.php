<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\AuditoriaBO;
use App\Models\Entidades\Auditoria;

class AuditoriaController extends Controller{
    public function listarAuditoria() {
        $bo = new AuditoriaBO();
        $usuarioBO = new \App\Models\BO\UsuarioBO();
        
        $tabela = Auditoria::TABELA;
        $campos = ['*'];
        $quantidade = 5;
        $p = is_numeric($_POST['pagina']) ? $_POST['pagina'] : 1;
        $pagina = $p * $quantidade - $quantidade;
        $condicao = "";
        $valorCondicao = [];
        $orderBy = "id desc";
        $debug = null;

        $lista = $bo->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        if($lista){
            for($i = 0; $i < count($lista); $i++){
                $usuario = $usuarioBO->selecionarVetor(\App\Models\Entidades\Usuario::TABELA, ['nome as "[nome]"', 'email as "[email]"', 'fone as "[fone]"', 'cargo as "[cargo]"'], 1, null, "id = ?", [$lista[$i]['usuario_id']], null);
                $lista[$i]['tipo'] = $this->tipo($lista[$i]['tipo']);
                $lista[$i]['descricao'] = strtr($lista[$i]['descricao'], $usuario);
            }
        }
        
        echo json_encode($lista);
    }

    public function verAuditoria() {
        $bo = new AuditoriaBO();
        $usuarioBO = new \App\Models\BO\UsuarioBO();
        
        $tabela = Auditoria::TABELA . ' a inner join '. \App\Models\Entidades\Usuario::TABELA . ' u on a.usuario_id = u.id';
        $campos = ['*', 'a.id', 'date_format(data, "%d/%m/%Y às %H:%i:%s") as data'];
        $quantidade = 1;
        $pagina = null;
        $condicao = "a.id = ?";
        $valorCondicao = [is_numeric($_POST['id']) ? $_POST['id'] : 0];
        $orderBy = "";
        $debug = null;

        $auditoria = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);

        if($auditoria){
            $usuario = $usuarioBO->selecionarVetor(\App\Models\Entidades\Usuario::TABELA, ['nome as "[nome]"', 'email as "[email]"', 'fone as "[fone]"', 'cargo as "[cargo]"'], 1, null, "id = ?", [$auditoria['usuario_id']], null);
            $auditoria['tipo'] = $this->tipo($auditoria['tipo']);
            $auditoria['descricao'] = strtr($auditoria['descricao'], $usuario);
        }
        
        echo json_encode($auditoria);
    }

    function tipo($tipo){
        switch ($tipo) {
            case 1:
                return "Inserção";
                break;

            case 2:
                return "Edição";
                break;

            case 3:
                return "Seleção";
                break;

            case 4:
                return "Exclusão";
                break;

            case 5:
                return "Login";
                break;

            case 6:
                return "Logoff";
                break;

            default:
                return "Outros";
                break;
        }
    }
}