<?php 

require_once("vendor/autoload.php");

use \Hcode\PageAdmin;
use \Hcode\Model\User;


//Rota para crud de usuarios, tela principal
$app->get("/admin/users", function(){

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));

});

//Rota para criação de usuarios
$app->get("/admin/users/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});

//Realiza a exclusão do usuario
$app->get("/admin/users/:iduser/delete", function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;

});

//Rota para o tpl alterar usuarios
$app->get("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));

});

//Realiza a criação do usuario via post
$app->post("/admin/users/create", function(){

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$_POST["despassword"] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [
		"cost"=>12]);

	$user->setData($_POST);

	$user->save();

	header("Location: /admin/users");
	exit;

});

//Realiza a atualização do usuario via post
$app->post("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;

});

//Realiza a exclusão do usuario
$app->get("/admin/users/:iduser/delete", function($iduser){

	User::verifyLogin();

});

 ?>