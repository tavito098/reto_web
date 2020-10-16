<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotizacion pdf</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
      <h2>Cotizacion</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Precio</th>
            </tr>
        </thead>
      <tbody>
        @foreach ($quotation as $data)
        <tr>
            <td>{{ $data->user['name'] }}</td>
            <td>{{ $data->product['name'] }}</td>
            <td>{{ $data->price }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>