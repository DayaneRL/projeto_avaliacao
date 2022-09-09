@extends('layouts.app')

@section('title')
    Visualização da prova
@endsection

@section('style')
    <style>
        #visualizacaoProva{
            width: 800px;
        }
        .answers{
            list-style-type: none;
            padding-left: 10px;
        }
    </style>
@endsection

@section('content')

    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row mb-3">
                    <button type="button" onclick="downloadProva()" class="btn btn-primary btn-icon-split p-2 ml-2">
                        <i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova
                    </button>
                    <button type="button" class="btn btn-primary btn-icon-split p-2 ml-2">
                        <i class="fas fa-eye mr-2 pt-1"></i> Visualizar gabarito
                    </button>
                </div>
                <div class="row mb-3 d-flex justify-content-center" >
                    <div class="card border border-secondary h-100 py-2">
                        <div class="card-body text-dark " id="visualizacaoProva">
                            <div class="testHeader">
                                <img src="{{asset('img/logocaraguasecretaria.png')}}"
                                class="d-inline"
                                width="300px">
                                <h5 class="d-inline">CEI/EMEI Prof° Aparecida Maria Pires de Meneses</h5>
                            </div>
                            {{-- quebra de opções --}}
                            <div class="headerInfo d-flex flex-column align-items-center">
                                <h3>{{$formData['name']}}</h3>
                                <h6 class="m-0">Professor {{Auth::user()->name}}</h6>
                                <h6 class="m-0 ">Caraguatatuba, 25 de maio de 2022</h6>
                            </div>




                            <div class="questions">

                                <h6 class="font-weight-bold mt-3">Questão 1</h6>
                                <p>Por mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.  mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.  mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.  mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.  mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.  mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações. mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.
                                    Tendemos a rejeitar fatos que ameaçam nosso senso de
                                    identidade e sempre buscar informações que confirmem
                                    nossas próprias crenças, seja por meio de memórias seletivas,
                                    leituras de fontes que estão do nosso lado ou mesmo
                                    interpretando os fatos de determinada maneira. Isso tudo
                                    está relacionado a não querermos ter nossas ideias, gostos,
                                    identidade questionados, e por isso temos dificuldade em
                                    aceitar o que contradiz aquilo em que acreditamos. De acordo com o texto:</p>
                                {{-- passa pra um banco de questoes imaginario,
                                    busca de la e muda isso tudo pra foereach --}}
                                <ul class="answers">
                                    <li>
                                        <span>A)</span>
                                        as pessoas bem informadas estão protegidas de
                                        polêmicas, uma vez que o modo como processam os fatos
                                        tornam suas opiniões mais convincentes.
                                    </li>
                                    <li>
                                        <span>B)</span>
                                        o posicionamento político garante a disseminação de
                                        notícias verdadeiras e resulta de crenças já estabelecidas
                                        socialmente.
                                    </li>
                                    <li>
                                        <span>C)</span>
                                        a rejeição a questionamentos impede que se admitam
                                        pontos de vista antagônicos, em razão da tendência de se
                                        confirmar crenças pessoais.
                                    </li>
                                    <li>
                                        <span>D)</span>
                                        as memórias seletivas auxiliam na rejeição de fatos
                                        contrários à realidade, já que conduzem à interpretação
                                        das reportagens de modo imparcial.
                                    </li>
                                    <li>
                                        <span>E)</span>
                                        os fatos hostis normalmente são preteridos por grande
                                        parte da sociedade, embora sejam utilizados como
                                        identificador cultural.
                                    </li>
                                </ul>

                                <h6 class="font-weight-bold mt-3">Questão 2</h6>
                                <p>Por mais bem informado que você possa ser, não dá para
                                    baixar a guarda. Mas por que as notícias falsas – mesmo
                                    aquelas mais improváveis – parecem tão convincentes para
                                    tantas pessoas? Van Bavel, professor de psicologia e ciência
                                    neural da Universidade de Nova York, se especializou em
                                    entender como as crenças políticas e identidades de grupo
                                    influenciam a mente, e descobriu que a identificação com
                                    posições políticas pode interferir em como o cérebro processa
                                    as informações.
                                    Tendemos a rejeitar fatos que ameaçam nosso senso de
                                    identidade e sempre buscar informações que confirmem
                                    nossas próprias crenças, seja por meio de memórias seletivas,
                                    leituras de fontes que estão do nosso lado ou mesmo
                                    interpretando os fatos de determinada maneira. Isso tudo
                                    está relacionado a não querermos ter nossas ideias, gostos,
                                    identidade questionados, e por isso temos dificuldade em
                                    aceitar o que contradiz aquilo em que acreditamos. De acordo com o texto:</p>
                                {{-- passa pra um banco de questoes imaginario,
                                    busca de la e muda isso tudo pra foereach --}}
                                <ul class="answers">
                                    <li>
                                        <span>A)</span>
                                        as pessoas bem informadas estão protegidas de
                                        polêmicas, uma vez que o modo como processam os fatos
                                        tornam suas opiniões mais convincentes.
                                    </li>
                                    <li>
                                        <span>B)</span>
                                        o posicionamento político garante a disseminação de
                                        notícias verdadeiras e resulta de crenças já estabelecidas
                                        socialmente.
                                    </li>
                                    <li>
                                        <span>C)</span>
                                        a rejeição a questionamentos impede que se admitam
                                        pontos de vista antagônicos, em razão da tendência de se
                                        confirmar crenças pessoais.
                                    </li>
                                    <li>
                                        <span>D)</span>
                                        as memórias seletivas auxiliam na rejeição de fatos
                                        contrários à realidade, já que conduzem à interpretação
                                        das reportagens de modo imparcial.
                                    </li>
                                    <li>
                                        <span>E)</span>
                                        os fatos hostis normalmente são preteridos por grande
                                        parte da sociedade, embora sejam utilizados como
                                        identificador cultural.
                                    </li>
                                </ul>

                            </div>





                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{-- node_modules\html2pdf.js\dist\html2pdf.bundle.js --}}
@section('js')
    <script src="{{asset('plugins/html2pdf/html2pdf.bundle.min.js')}}"></script>
    <script>
        function downloadProva(){
            var element = document.getElementById('visualizacaoProva');
            var opt = {
                filename: "{{$formData['name']}}",
                html2canvas: {
                    dpi: 192,
                    scale:4,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection
