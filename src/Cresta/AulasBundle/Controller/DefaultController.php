<?php

namespace Cresta\AulasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CrestaAulasBundle:Default:index.html.twig', array());
    }
    
    public function acercadeAction()
    {
        return $this->render('CrestaAulasBundle:Default:acercade.html.twig', array());
    }

    public function ayudaAction()
    {
        return $this->render('CrestaAulasBundle:Default:ayuda.html.twig', array());

    }

    //funcion agregada para dump de bbdd
    public void function dumpAction()
    {
        $dbhost=$this->container->getParameter('database_host');
        $dbname=$this->container->getParameter('database_name');
        $dbuser=$this->container->getParameter('database_user');
        $dbpass=$this->container->getParameter('database_password');
        $pathActual = getcwd() . '/'; //trae el path actual 
        $backup_file = $pathActual . 'Gestion-Aulas' . date("H-i-s-d-m-Y") . '.sql';
        $NombreBackup =  'Gestion-Aulas ' . date("H-i-s-d-m-Y") . '.sql';

        //Comando a ejecutar
        $command = "mysqldump --user=$dbuser --password=$dbpass $dbname > $backup_file";

        //system($command,$sarasa);
        system($command,$output);

        if (($output =='0')){  //Si se creó con exito el BackUp
            //return $this->render('CrestaAulasBundle:Default:exitodump.html.twig', array());            
            echo "<script type='text/javascript'>
                  alert('El resguardo de la base de datos se realizo correctamente! El backup se encuentra en la carpeta Web de symfony');
                </script>";
            //header("Location:{{ path('_homepage') }}");
            //return true;
            //return $this->render('CrestaAulasBundle:Default:index.html.twig', array());
            //return $this->render('CrestaAulasBundle:Reserva:index.html.twig', array());
            
            }                         
        else { //Si no se creó el BackUp
            //return $this->render('CrestaAulasBundle:Default:errordump.html.twig', array());
              echo "<script type='text/javascript'
                  alert('El resguardo de la base de datos NO se realizo correctamente!');
                </script>";
            //header("Location:{{ path('_homepage') }}");
            //return true;
            //return $this->render('CrestaAulasBundle:Default:index.html.twig', array());
            //return $this->render('CrestaAulasBundle:Reserva:index.html.twig', array());
            }                         
    }
}
?>
