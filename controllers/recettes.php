<?php

    /**
     * Created by PhpStorm.
     * User: Mouhssine Soumairi
     * Date: 16/02/2017
     * Time: 22:25
     */
    class Recettes extends Controller
    {
        protected function index(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->Index(), true);
        }
        protected function totaldumois(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->TotalDuMois(), true);
        }

        protected function lists(){
        	$viewmodel = new RecetteModel();
        	$this->returnView($viewmodel->Lists(), true);
        }
        //pour modifier la date d'emission
        protected function emis(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->Emis(), true);
        }
        
        protected function add(){
        	$viewmodel= new RecetteModel();
        	$this->returnView($viewmodel->add(), true);
        }
        protected function etatannuel(){
        	$viewmodel = new RecetteModel();
        	$this->returnView($viewmodel->etatannuel(), true);
        }
        protected function modifier(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->UpdateRecette(), true);
        }
        protected function update(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->UpdateRecette(), true);
        }
        protected function delete(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->SupprimerRecette(), true);
        }
        protected function etatdujour(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->etatorjour(), true);
        }
        protected function etatdumois(){
            $viewmodel = new RecetteModel();
            $this->returnView($viewmodel->etatormois(), true);
        }
    }
