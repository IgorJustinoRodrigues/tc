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
        $tipo_usuario = $bo->listarVetor(TipoUsuario::TABELA, ['*'], null, null, "", [], 'descricao');
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
                    
                    $info = [
                        'tipo' => 1,
                        'tabela' => Usuario::TABELA,
                        'campos' => $dados,
                        'descricao' => 'O usuario [nome], efetuou o cadastro de um novo usuário no sistema.'
                    ];

                    $this->inserirAuditoria($info);

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

    public function listar($parametro) {
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        $bo = new UsuarioBO();
        
        if(!is_numeric($parametro[0])){
            $this->redirect('usuario/listar/1/'. $parametro[0]);
        }
        
        $p = (isset($parametro[0]) or is_numeric($parametro[0])) ? $parametro[0] : 1;
        $busca = (isset($parametro[1])) ? $parametro[1] : "";
        
        $quantidade = 5;
        $pagina = $p * $quantidade - $quantidade;
        
        $condicao = "";
        $valoresCondicao = [];

        if($busca){
            $condicao .= "nome like '%?%' ";
            array_push($valoresCondicao, "$busca");
        }
        
        $orderBy = "nome asc";
        
        $resultado = $bo->listar(Usuario::TABELA, ["*"], $quantidade, $pagina, $condicao, $valoresCondicao, $orderBy);
        $this->setViewParam('usuarios', $resultado);
        $quanUsuarios = $bo->selecionar(Usuario::TABELA, ["count(id) as id"], null, null, $condicao, $valoresCondicao, $orderBy);

        $quanPaginas = ceil($quanUsuarios->getId() / $quantidade);

        if($p > $quanPaginas and $p != 1){
            Sessao::gravaMensagem("Página não encontrada!");
            $this->redirect('usuario/listar');
        }
        
        if($p < 5){
            $i = 0;
            $fim = $quanPaginas < 5 ? $quanPaginas : 5;   
        }else{
            if($p < $quanPaginas - 2){
                $i = $p - 3;
                $fim = $p + 2;
            } else {
                $i = $quanPaginas - 5;
                $fim = $quanPaginas;                                        
            }
        }

        $paginacao = array(
            'quanUsuarios' => $quanUsuarios->getId(),
            'quanPaginas' => $quanPaginas,
            'inicio' => $i,
            'fim' => $fim,
            'pagina' =>$p,
            'anterior' => $p - 1,
            'proxima' => $p + 1,
            'busca' => $busca
        );
        $this->setViewParam('paginacao', $paginacao);

        if($quanUsuarios->getId() < 1){
            Sessao::gravaMensagem('Nenhum registro encontrado!');
        }

        $this->render('usuario/listar', "Lista de usuarios");
    }

    public function visualizar($parametro) {
        $this->validaUsuario();
        $this->nivelAcesso(1);
       
        $id = $parametro[0];

        if(is_numeric($id)){
            $bo = new UsuarioBO();

            $tabela = Usuario::TABELA;
            $campos = ['*'];
            $condicao = "id = ?";
            $quantidade = 1;
            $pagina = null;
            $valorCondicao = [$id];
            $orderBy = null;
            $debug = false;

            $usuario = $bo->selecionar($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);

            if($usuario->getId() == FALSE){
                $mensagem = "Usuário não encontrado.";
                Sessao::gravaMensagem($mensagem);

                $this->redirect('usuario/listar');
            }else{
                $bo = new TipoUsuarioBO();
                $tipo_usuario = $bo->listarVetor(TipoUsuario::TABELA, ['*'], null, null, "status = ?", [1], 'descricao');
                $this->setViewParam('tipo_usuario', $tipo_usuario);

                $mensagem = "Dados de " . $usuario->getNome();
                Sessao::gravaMensagem($mensagem);
                
                $this->setViewParam('usuario', $usuario);
                $this->render('usuario/visualizar', "Usuário: ".$usuario->getNome());
            }
        } else {
            $mensagem = "Acesso incorreto!";
            Sessao::gravaMensagem($mensagem);

            $this->redirect('usuario/listar');
        }
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
        $info = [
            'tipo' => 6,
            'tabela' => Usuario::TABELA,
            'campos' => array(),
            'descricao' => 'O usuario [nome], saiu do sistema.'
        ];

        $this->inserirAuditoria($info);

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
                
                $tabela = Usuario::TABELA . ' u inner join ' . TipoUsuario::TABELA . ' t on u.tipo_usuario_id = t.id';
                $campos = ['u.*', 't.descricao as tipo_usuario'];
                $quantidade = 1;
                $pagina = null;
                $condicao = "(nome = '?' and senha = '?') or (email = '?' and senha = '?')";
                $valorCondicao = [$nome, $senha, $nome, $senha];
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
                        'tipo' => 5,
                        'tabela' => Usuario::TABELA,
                        'campos' => array(),
                        'descricao' => 'O usuario [nome], efetuou login no sistema.'
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