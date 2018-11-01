@extends('pdf.master')
@section('body')
<br>
<br>
<br>
<br>
<table class="table table-condensed table-bordered">
    <thead>
        <tr class="active">
            <th class="text-center">Indicador</th>
            <th class="text-center">Malo</th>
            <th class="text-center">Regular</th>
            <th class="text-center">Excelente</th>
            <th class="text-center">Meta</th>
            <th class="text-center">Resultado</th>
            <th class="text-center">Plan Estratégico</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($resultados as $resultado)    
            <tr class="text-center">
                <td>{{ $resultado->nombreIndicador }}</td>
                <td>{{ $resultado->malo }}</td>
                <td>{{ $resultado->regular }}</td>
                <td>{{ $resultado->excelente }}</td>
                <td>{{ $resultado->metaIndicador }}</td>
                <td>{{ $resultado->respuestaUsuario }}</td>
                <td>{{ $resultado->plan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection