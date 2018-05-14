<!-- create.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reservas</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap-responsive.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/fullcalendar.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/matrix-style.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/matrix-media.css')}}"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  
    <link type="text/css" href="{{asset('css/jquery-ui-1.8.1.custom.css')}}" rel="Stylesheet" /> 
    <link type="text/css" href="{{asset('css/boostrap.css')}}" rel="Stylesheet" /> 
    <script type="text/javascript" src="{{asset('js/jquery-1.4.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui-1.8.1.custom.min.js')}}"></script> 
    <script>
    $(document).ready(function(){
       var cant = [];
       var filas = ['A', 'B', 'C', 'D', 'E'];
       var Colum = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
       var todaButaca = '';

       $(".listarButaca").click(function(){
        if (cant.length > 0) {
        for (var i = 0; i < cant.length; i++) {
          todaButaca = todaButaca +',' +cant[i];
        }
        $("#fil_col").val(todaButaca);
        document.getElementById("formulario").submit();
      }})
/*
       $(".limpiarButacas_").click(function(){
        var listadoButacas = document.getElementById('fil_col').value;
        if (listadoButacas.length > 0) {
          var listarMisButacas = listadoButacas.split(',');
            alert('si hay');
        }})
*/

      for(i=0; i<filas.length; i++){
          for (var j =0; j < Colum.length; j++) {
          letraActual = $('<button type="button" onClick="this.disabled=true" style="width:35px; height:25px;" class="botonletra btn-primary" id="'+filas[i] + Colum[j]+'">'+ filas[i] + Colum[j] + '</button>');
          letraActual.data("letra",filas[i] + Colum[j]);
          $("#botonesletras").append(letraActual);   
          }
          $("#botonesletras").append($('<Br/>'));   
       }

       $(".botonletra").click(function(){
          var catidad = document.getElementById('IdCant').value;
          var boton = document.querySelector("#"+$(this).data("letra"));
          if (catidad.length > 0) {
             if (catidad > cant.length) {
            cant.push($(this).data("letra"));
            boton.style.backgroundColor = "green"; 
          }else{
             alert('Solo Puede Seleccionar ' + catidad + ' Butacas');
          }
       }else{
          alert('Debe Introducir una cantidad de Butacas');
       }})

    });
    </script>
    <style type="text/css">
      .botonletra{
         font-size: 0.8em;
         margin: 2px;
      }
      .dialogletra{
         font-size: 3em;
         text-align: center;
         padding-top: 15px;
      }
    </style>

  </head>
<body>
<div id="header">
    <h1><a href="index_admin.html">Inicio</a></h1>
</div>
<div id="sidebar"><a href="/reservarbutaca" class="visible-phone" title="Regresar al Inicio" ><i class="icon icon-home"></i> Inicio</a>
  <ul>
    <li class="active"> <a href="/reservarbutaca/create"><i class="icon icon-home"></i><span>Agregar</span></a> </li>
    <li class="active"> <a href="/reservarbutaca"><i class="icon icon-th-list"></i><span>Consultar</span></a></li>
  
  </ul>
</div>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="/reservarbutaca" class="tip-bottom"><i class="icon-home"></i>Inicio</a>
    </div>
</div>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Crear Reserva...</h5>
        </div>
        <div class="widget-content nopadding">
          <!-- nombres, apellidos, fecha, nro persona, butaca fila columna, disponible -->

        <form method="post" id="formulario" action="{{action('ReservarButacaController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
         <div class="control-group">
                <label for="nombres">Nombres:</label>
                <div class="controls">
                 <input type="text" class="form-control" name="nombres" value="{{$usuarios->nombres}}">
                </div>
            </div>
            <div class="control-group">
                <label for="apellidos">Apellidos:</label>
                <div class="controls">
                 <input type="text" class="form-control" name="apellidos" value="{{$usuarios->apellidos}}">
                </div>
            </div>
            <div class="control-group">
                <strong>Fecha: </strong> 
                <div class="controls">                   
                <input type="text" class="date form-control" id="datepicker" name="date" value="{{$usuarios->fecha}}">   
                </div>  
            </div>
       
        <div class="control-group">
                <label for="cantidad_personas">Cantidad Personas:</label>
                <div id="botonesletras">
                  <input type="number" id="IdCant" name="cantidad_personas" value="{{$usuarios->nropersonas}}">
                   <br/>
                </div>
             </div>   
             <input type="hidden" id="fil_col" name="fila_columna"/>
            <div class="control-group">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4" style="margin-top:30px">
                <button type="submit" class="listarButaca btn btn-success">Actualizar</button>
            </div>
      </form>                                    
        </div>
      </div>
    </div> 
  </div>
</div>
                  
</div>

<div class="row-fluid">
<div id="footer" class="span12"> 2018 &copy; Verusca Romero</a> </div>
</div>

<script type="text/javascript">  
  $('#datepicker').datepicker({ 
  autoclose: true,   
  format: 'dd-mm-yyyy'  
  });  
</script>

</body>
</html>