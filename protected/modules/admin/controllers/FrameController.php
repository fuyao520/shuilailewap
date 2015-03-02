<?php
class FrameController extends AdminController{
	public function actionIndex(){
		
		$this->render('index');
	}
	public function actionTop(){
		$this->render('top');
	}
	public function actionLeft(){
	
		$this->render('left');
	}
	public function actionWelcome(){
	
		$this->render('welcome');
	}
	
	
	
}