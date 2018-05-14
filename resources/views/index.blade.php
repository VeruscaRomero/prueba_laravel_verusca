<!-- index.blade.php -->

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
  </head>
  <body>
    <div id="header">
        <h1><a href="index_admin.html">Inicio</a></h1>
    </div>
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class=""><a title="" href="/reservarbutaca"><i class="icon icon-share-alt"></i> <span class="text">Salir</span></a></li>
        </ul>
    </div>
    <div id="sidebar"><a href="inicio.htm" class="visible-phone" title="Regresar al Inicio" ><i class="icon icon-home"></i> Inicio</a>
      <ul>
        <li class="active"> <a href="/reservarbutaca/create"><i class="icon icon-home"></i><span>Agregar</span></a> </li>
        <li class="active"> <a href="/reservarbutaca"><i class="icon icon-th-list"></i><span>Consultar</span></a></li>
      </ul>
    </div>
    <div id="content">
      <div id="content-header">
          <div id="breadcrumb"> <a href="index_admin.htm" class="tip-bottom"><i class="icon-home"></i>Inicio</a>
      </div>
    </div>
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif

    <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($usuarios as $usuario)
      <tr>
        <td>{{$usuario['idusuarios']}}</td>
        <td>{{$usuario['nombres']}}</td>
        <td>{{$usuario['apellidos']}}</td>        
        <td><a href="{{action('ReservarButacaController@edit', $usuario['idusuarios'])}}" class="btn btn-warning">Edit</a></td>
        <td>
          <form action="{{action('ReservarButacaController@destroy', $usuario['idusuarios'])}}" method="post">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  <div id="footer" class="span12"> 2018 &copy; Verusca Romero </div>
  </body>
</html>