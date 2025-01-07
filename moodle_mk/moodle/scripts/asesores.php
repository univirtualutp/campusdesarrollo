<?php

require_once(dirname(__FILE__).'/../config.php');
require_login();
$id_curso = intval($_REQUEST['id_curso']);
//$id_curso = 140;
$id_usuario = $USER->id;

//Muestra la Plantilla
$sql="
SELECT c.lang 
FROM mdl_course c
where c.id = ".$id_curso;
//Ejecuta la consulta en la BD
$idioma="";
$result= $DB->get_records_sql($sql);
if(!empty($result)){
    foreach($result as $res){
        $idioma=$res->lang;
    }
}
#-----------------------------------------------------------------------------
# Arma la instruccion para consultar las categorias 
# exceptuando la categoria 5 herramientas de comunicación general
#-----------------------------------------------------------------------------
$sql="
SELECT  DISTINCT u.username as usuario, u.firstname as nombre, u.lastname as apellidos, u.email as correo, u.id as userid, (select j.id from mdl_context j WHERE j.instanceid=u.id AND j.contextlevel=30) as contextid
FROM mdl_user u
JOIN mdl_role_assignments a ON (a.userid=u.id)
JOIN mdl_context t ON (t.id = a.contextid)
JOIN mdl_course c ON (c.id =t.instanceid)
WHERE c.id = ".$id_curso."
AND t.contextlevel= 50
AND a.roleid = 18";

$result= $DB->get_records_sql($sql);
foreach($result as $res){

    $url_sitio = 'https://aulavirtual.utp.edu.co/';
    if ($res->contextid != ''){
        $url_foto = $url_sitio.'pluginfile.php/'.$res->contextid.'/user/icon/boost/f1';
    }else{
        $url_foto = $url_sitio.'theme/image.php/boost/core/1571244299/u/f1';

    }
    $url_perfil = $url_sitio."user/view.php?id=".$res->userid."&course=".$id_curso;
    $url_mensaje = $url_sitio."message/index.php?id=".$res->userid;
    
    if($idioma == "en"){
        $etiqueta_enviar_mensaje = "Do you need help?";
    }else{
        $etiqueta_enviar_mensaje = "¿Necesita ayuda?";
    }

    echo "<div class='usuario'>
            <a class='foto-usuario' href='".$url_perfil."' target='_blank'> 
                <img class='borde-foto img-responsive' src='".$url_foto."' /> 
            </a> 
            <a href='".$url_perfil."' target='_blank'> ".$res->nombre." ".$res->apellidos."
            </a><br />
            <a class='aside-button' href='".$url_mensaje."'>".$etiqueta_enviar_mensaje."</a>
        </div><p></p>";
}
?>