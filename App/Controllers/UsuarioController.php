<?php
namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\UsuarioBO;
use App\Models\Entidades\Usuario;
use App\Models\BO\TipoUsuarioPermissaoBO;
use App\Models\BO\TipoUsuarioBO;
use App\Models\Entidades\TipoUsuario;
use App\Models\Entidades\TipoUsuarioPermissao;
use App\Models\Entidades\Permissao;


class UsuarioController extends Controller{
    public function index(){
        $this->validaUsuario();
        
        $this->render('usuario/index', 'Usuários');
    }
    
    public function cadastro() {
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        $bo = new TipoUsuarioBO();
        $tipo_usuario = $bo->listarVetor(TipoUsuario::TABELA, ['*'], null, null, "status = ?", [1], 'descricao');
        $this->setViewParam('tipo_usuario', $tipo_usuario);
        
        $this->render('usuario/cadastro', "Cadastro de usuário");
        Sessao::limpaFormulario();
    }

    public function salvar(){
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        if($_POST){
            $bo = new UsuarioBO();
            $vetor = $_POST;
            
            if(!is_numeric($vetor['id'])){
                Sessao::gravaFormulario($_POST);
                $dados = array();
                $campos = Usuario::CAMPOS;

                if(trim($vetor['senha']) == '' or $vetor['senha'] != $vetor['senha2']){
                    $mensagem = "Senhas não conferem!";
                    Sessao::gravaMensagem($mensagem);

                    $this->redirect('usuario/cadastro');                    
                }
                
                foreach ($vetor as $indice => $valor) {
                    if(in_array($indice, $campos)){
                        if ($vetor[$indice] == '') {
                            $dados[$indice] = "null";
                        }else{
                            $dados[$indice] = $vetor[$indice];
                        }
                    }
                }
                
                if($dados['status'] == "on"){
                    $dados['status'] = 1;
                } else {
                    $dados['status'] = 2;
                }

                $dados['senha'] = md5($dados['senha']);
                $dados['cadastro'] = date('Y-m-d H:i:s');
                $validacao = Usuario::OBRIGATORIO;
                
                $id = $bo->inserir(Usuario::TABELA, $dados, $validacao);
                
                if($id == false){
                    Sessao::gravaMensagem("Falha ao cadastrar");
                    $this->redirect('usuario/cadastro');
                }else{
                    Sessao::limpaFormulario();
                    Sessao::gravaMensagem("Cadastrado com sucesso!");
                    $this->redirect('usuario/visualizar/'.$id);
                }
            }else{
                $dados = array();
                $campos = Usuario::CAMPOS;

                foreach ($vetor as $indice => $valor) {
                    if(in_array($indice, $campos)){
                        if ($vetor[$indice] == '') {
                            $dados[$indice] = "null";
                        }else{
                            $dados[$indice] = $vetor[$indice];
                        }
                    }
                }

                $validacao = Usuario::OBRIGATORIO;
                $condicao = "id = ?";
                $valorCondicao = [$vetor['id']];
                
                $resposta = $bo->update(Usuario::TABELA, $dados, $condicao, $valorCondicao, 1, $validacao);
                
                if(!$resposta){
                    $mensagem = "Usuário sem alteração";
                    Sessao::gravaMensagem($mensagem);

                    $this->redirect('usuario/visualizar/'.$vetor['id']);
                }else{               
                    $mensagem = "Usuário " . $vetor['nome'] . " alterado";
                    Sessao::gravaMensagem($mensagem);

                    $this->redirect('usuario/visualizar/'.$vetor['id']);
                }  
            }
            
        }else{
            Sessao::gravaMensagem("Acesso Incorreto!");
            $this->redirect('usuario/cadastro');
        }
        
        $this->redirect('usuario/listar');
    }
        
    public function login(){
        if(Sessao::logado()){
            $mensagem = "O " . Sessao::getUsuario('cargo') . " " . Sessao::getUsuario('nome') . ", está logado no sistema!<br>Você não é o(a) " . Sessao::getUsuario('nome') . '? <a href="'.LINK.'usuario/sair" class="btn yellow white-text">Sair!</a>';
            Sessao::gravaMensagem($mensagem);

            $this->redirect('home/painel');
        }
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
                                                
                    $info = [
                        'tipo' => 4,
                        'tabela' => null,
                        'campos' => array(),
                        'descricao' => 'O usuario [nome]'
                    ];

                    $this->inserirAuditoria($info);

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