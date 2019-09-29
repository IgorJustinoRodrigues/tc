<?php

namespace App\Controllers;

use App\Lib\Sessao;

abstract class Controller{
    protected $app;
    private $viewVar;

    public function __construct($app){
        $this->setViewParam('nameController',$app->getControllerName());
    }

    public function render($view, $titulo = null){

        $viewVar = $this->getViewVar();
        
        $Sessao  = Sessao::class;
        
        if(trim($titulo) != ''){
            $titulo = " | " . $titulo;
        }
        
        if(file_exists("./public/css/".$view.".css")){
            $css .= '<link href="'.CSS.'/'.$view.'.css" type="text/css" rel="stylesheet"/>';
        } else {
            $css = '<link href="'.CSS.'/estilo.css" type="text/css" rel="stylesheet"/>';
        }

        if(file_exists("./public/js/".$view.".js")){
            $js = '<script src="'.JS.'/'.$view.'.js"></script>';
        }

        require_once PATH . '/App/Views/layouts/header.php';
        require_once PATH . '/App/Views/layouts/menu.php';
        require_once PATH . '/App/Views/' . $view . '.php';
        require_once PATH . '/App/Views/layouts/footer.php';             
    }

    public function redirect($view){
        header('Location: http://' . APP_HOST . $view);
        exit;
    }

    public function getViewVar(){
        return $this->viewVar;
    }

    public function setViewParam($varName, $varValue){
        if ($varName != "" && $varValue != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }
    
    public function upload($file, $caminho, $nome = null, $largura = null, $altura = null) { 
        
        if($file["name"] != ""){
            //Receber os dados do formulário
            $tmp_nome = $file['tmp_name'];
            $nome_envio = $file['name'];

            $ext = strtolower(strrchr($nome_envio,"."));

            if($nome != ''){
                $nome = $nome . $ext;
            } else {
                $nome = date('d_m_Y_h_i_s') . "_" . rand(11111, 99999) . $ext;
            }

            //Fazer o Upload 
            move_uploaded_file($tmp_nome, $caminho . $nome);

            if(file_exists($caminho. $nome)){
                
                if($ext != '.gif' and $ext != '.png'){
                    if($largura and $altura){
                        $img = new Canvas();
                        
                        $img->carrega( $caminho . $nome )
                            ->hexa( '#FFFFFF' )                        
                            ->redimensiona( $largura, $altura, 'preenchimento' )
                            ->grava($caminho. $nome, 80);
                    }
                }
                
                return $nome;
            } else {
                return FALSE;
            }
        }
        
        return FALSE;
    }
    
    public function remover_caracter($string) {
        $string = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($string))));
        $string = str_replace("+","_", $string);
        return $string;  
    }
    
    public function status($status){
        switch ($status) {
            case 1:
                return 'Ativo';
                break;
            case 2:
                return 'Desativado';
                break;
            case 0:
                return 'Excluido';
                break;

            default:
                return 'Outros';
                break;
        }
    }
    
    public function validaUsuario($tempo = 6000){

        if(!Sessao::logado()){
            Sessao::gravaMensagem('Acesse a sua conta!');
            Sessao::setUsuario(null);
            Sessao::setLogado(false);
            $this->redirect('usuario/login');
            exit();
        } else {
            header("Refresh:$tempo; url=".LINK."usuario/sair");
        }
    }
    
    public function nivelAcesso($nivel, $caminho = 'home/painel'){
        $permissoes = Sessao::getUsuario("permissoes");
        
        if(!in_array($nivel, $permissoes)){
            Sessao::gravaMensagem("Você não tem permissão para acessar este recurso.<br>Nível de acesso " . $nivel);
            $this->redirect($caminho);
        }
    }
    
    public function inserirAuditoria($info){
        $bo = new \App\Models\BO\AuditoriaBO();
        $tabela = \App\Models\Entidades\Auditoria::TABELA;
        
        $campos = json_encode($info['campos']);
        
        $dados = [
            'tipo' => $info['tipo'],
            'usuario_id' => Sessao::getUsuario('id'),
            'tabela' => $info['tabela'],
            'campos' => $campos,
            'descricao' => $info['descricao'],
            'data' => date("Y-m-d H:i:s")
        ];
        $validacao = [];
        
        $bo->inserir($tabela, $dados, $validacao);
    }
    
    public function atualizar_dados_usuario_sessao() {
        $bo = new \App\Models\BO\UsuarioBO;

        $tabela = \App\Models\Entidades\Usuario::TABELA . " a inner join " . \App\Models\Entidades\TipoUsuario::TABELA . " t on a.tipo_usuario_id = t.id";
        $campos = ['a.*', 'date_format(a.cadastro, "%d/%m/%Y %H:%i") as cadastro', 't.descricao as tipo_usuario_nome'];
        $quantidade = 1;
        $pagina = null;
        $condicao = "a.id = ?";
        $valorCondicao = [Sessao::getUsuario('id')];
        
        $usuario = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, null);

        $tipoUsuarioPermissaoBO = new \App\Models\BO\TipoUsuarioPermissaoBO();
        $tipoPermissoes = $tipoUsuarioPermissaoBO->listarVetor(\App\Models\Entidades\TipoUsuarioPermissao::TABELA . ' tup inner join ' . \App\Models\Entidades\Permissao::TABELA . ' p on tup.permissao_id = p.id', ['p.nivel'], null, null, "tup.tipo_usuario_id = ? and p.status = 1 GROUP BY p.nivel", [$usuario['tipo_usuario_id']], 'p.nivel');

        $permissoes = array();

        if($usuario){
            foreach ($tipoPermissoes as $key => $item){
                array_push($permissoes, $item['nivel']);
            }
            
            $usuario['permissoes'] = $permissoes;
        
            Sessao::setUsuario($usuario);
        }
    }

}