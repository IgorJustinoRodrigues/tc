<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\UsuarioBO;
use App\Models\Entidades\Usuario;

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

        $this->redirect('/usuario/login');
    }
    
    public function entrar() {
        if($_POST){
            $vetor = $_POST;
            
            $nome = $vetor['nome'];
            $senha = $vetor['senha'];

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
                    Sessao::setUsuario($usuario);
                    Sessao::setLogado(true);
                    Sessao::limpaFormulario();

                    Sessao::gravaMensagem('Seja bem-vindo(a) ' . Sessao::getUsuario('nome') . '! login efetuado com sucesso.');

                    $this->redirect('relatorio/');
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