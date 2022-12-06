@extends('layouts.app')

@section('title')
    Visualizar Avaliação
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card  border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Avaliação - {{$exam->title}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('exams.index')}}" class="btn btn-light border btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Voltar</span>
                        </a>
                        <a href="/exams/{{$exam->id}}/edit" class="btn btn-info btn-icon-split">
                            <span class="text">Editar</span>
                        </a>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="d-none" id="exam_id">{{$exam->id}}</div>
                    <h3 id="exam_title">{{$exam->title}}</h3>

                    <p><b>Tags:</b> {{$exam->tags_list}} </p>
                    <p><b>Total de questões:</b> {{$exam->number_of_questions}} </p>
                    <p><b>Categoria:</b> {{$exam->Category->name}} </p>
                    <p><b>Data da prova:</b> {{$exam->exam_date}} </p>
                    <hr/>
                        @foreach ($exam->Attributes as $attribute)
                            <p><b> - Questões Aleatórias - </b></p>
                            <p><b>Qtd. de questões:</b> {{$attribute->number_of_questions}},
                            <b>Nível:</b> {{$attribute->Level->name}} </p>
                        @endforeach
                        <p><b> - Questões Privadas - </b></p>
                        <p><b>Qtd. de questões:</b> {{$questions_private->count()}}</p>

                    <hr/>

                    <div class="mt-2">
                        <button type="button" class="btn btn-info btn-icon-split p-2" onclick="downloadTest()">
                            Baixar prova
                        </button>
                        <button type="button" class="btn btn-warning btn-icon-split p-2" onclick="downloadAnswers()">
                            Baixar gabarito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">

function downloadTest() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: "/exams/download_exam",
        type: 'POST',
        data: {
            title: $('#exam_title').text(),
            id: $('#exam_id').text()
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = $('#exam_title').text()+'.pdf';
            link.click();
        },
        error: function(blob) {
            console.log(blob);
        }
    });
}

function downloadAnswers() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: "exams/download_answers",
        type: 'POST',
        data: {
            title: $('#exam_title').text(),
            id: $('#exam_id').text()
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'Gabarito da '+$('#exam_title').text()+'.pdf';
            link.click();
        },
        error: function(blob) {
        }
    });
}

</script>

@endsection
