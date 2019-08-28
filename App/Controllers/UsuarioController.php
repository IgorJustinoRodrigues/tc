<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\UsuarioBO;
use App\Models\Entidades\Usuario;
use App\Models\BO\TipoUsuarioPermissaoBO;
use App\Models\Entidades\TipoUsuarioPermissao;
use App\Models\Entidades\Permissao;


class UsuarioController extends Controller{
    public function index(){
        $this->validaUsuario();
        
        $this->render('usuario/index', 'Usuários');
    }
    
    public function login(){
        $this->render('usuario/login');
    }
    
    public function sair() {
        Sessao::setUsuario(null);
        Sessao::setLogado(false);
        
        Sessao::gravaMensagem('Você saiu do sistema com sucesso!');

        $this->redirect('usuario/login');
    }
    
    public function entrar() {
        if($_POST){
            $vetor = $_POST;
            
            $nome = $vetor['nome'];
            $senha = md5($vetor['senha']);

            if($nome != '' and $senha != ""){
                Sessao::gravaFormulario($vetor);

                $bo = new UsuarioBO();
                
                $tabela = Usuario::TABELA;
                $campos = ['*'];
                $quantidade = 1;
                $pagina = null;
                $condicao = "nome = '?' and senha = '?'";
                $valorCondicao = [$nome, $senha];
                $orderBy = null;                

                $usuario = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy);

                if($usuario){
                    $tipoUsuarioPermissaoBO = new TipoUsuarioPermissaoBO();
                    $tipoPermissoes = $tipoUsuarioPermissaoBO->listarVetor(TipoUsuarioPermissao::TABELA . ' tup inner join ' . Permissao::TABELA . ' p on tup.permissao_id = p.id', ['p.nivel'], null, null, "tup.tipo_usuario_id = ? and p.status = 1 GROUP BY p.nivel", [$usuario['tipo_usuario_id']], 'p.nivel');

                    $permissoes = array();

                    foreach ($tipoPermissoes as $key => $item){
                        array_push($permissoes, $item['nivel']);
                    }

                    $usuario['permissoes'] = $permissoes;

                    Sessao::setUsuario($usuario);
                    Sessao::setLogado(true);
                    Sessao::limpaFormulario();

                    Sessao::gravaMensagem('Seja bem-vindo(a) ' . Sessao::getUsuario('nome') . '! login efetuado com sucesso.');

                    $this->redirect('home/painel');
                } else {

                    Sessao::gravaMensagem('Nome e/ou senha incorreto.');
                }

            } else {
                Sessao::gravaMensagem('Preencha todos os dados corretamente.');
            }

            $this->redirect('usuario/login');
        } else {
            Sessao::gravaMensagem("Erro: Acesso incorreto!");
            $this->redirect('usuario/login');
        }
    }
}