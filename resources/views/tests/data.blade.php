<html class='visualization'>
<body class='visualization'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/assets/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
@foreach ($questions as $question)
<?php
$question->json = json_decode($question->json,true);
$contador = 1;
?>
@endforeach
<style>
	html.visualization{
		width: 100%;
		background-color: gray;
	}
	body.visualization{
		width: 210mm;
		background-color: white;
		padding: 30px;
		margin: auto;
	}
	img{
		max-width:100%;
	}
</style>
<div name="editor" id="editor">
  @foreach ($questions as $question)
  <div class="question question_{{$question['id']}}">
   <p class="description">{{$contador}}) {{$question->json['description']}}</p>
   @if(isset($question->json['image_name']))
   <p class="img"><img style="width:100%;" src="{{ url('/assets/images/uploads/'.$question->json['image_name']) }}"/></p>
   @endif
   @if ($question->json['answer_type']=="txt")
   @for ($i = 0; $i<$question->json['lines_number']; $i++)
   <hr>
   @endfor
   @elseif ($question->json['answer_type']=="opt")
   <?php
   $contadora = 0;
   ?>
   @foreach ($question->json['answers'] as $answer)
   <div class="answer">
    {{chr($contadora+97)}})
    <input type="radio" value="1" 
    disabled
    @if ($answer['right'])
    checked="checked"
    checkedTrue="true"
    @endif
    >
    {{$answer['description']}}
    @if(array_key_exists('image_name',$answer))
    <p class="img"><img style="width:100%;" src="{{url('/assets/images/uploads/'.$answer['image_name']) }}"/></p>
    @endif
  </div>
  <?php
  $contadora++;
  ?>
  @endforeach
  @elseif ($question->json['answer_type']=="vof")
  @foreach ($question->json['answers'] as $answer)
  <div class="answer">
    <input type="checkbox" value="1" 
    disabled
    @if ($answer['right'])
    checked="checked"
    checkedTrue="true"
    @endif
    >
    {{$answer['description']}}
    @if(array_key_exists('image_name',$answer))
    <p class="img"><img style="width:100%;" src="{{url('/assets/images/uploads/'.$answer['image_name']) }}"/></p>
    @endif
  </div>
  @endforeach

  @endif
</div>
<?php
$contador++;
?>
@endforeach
</div>

<div class="container" id="gabarito_aluno">
  <div class="row">
    <?php
    $contador = 1;
    ?>
    @foreach ($questions as $question)
    @if ($question->json['answer_type']!="txt")
    <?php
    $contadora = 0;
    ?>
    <div class="col-md-4 col-sm-4 col-xs-4">
    {{$contador}}
      <div class="container">
        <div class="row">
          @foreach ($question->json['answers'] as $answer)
          <div class="col-md-1 col-sm-1 col-xs-1" style="border: 1px solid gray;"><small>{{chr($contadora+97)}} </small></div>
          <?php
          $contadora++;
          ?>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    <?php
    $contador++;
    ?>
    @endforeach
  </div>
</div>

<div class="container" id="gabarito_professor" style="display:none;">
  <div class="row">
    <?php
    $contador = 1;
    ?>
    @foreach ($questions as $question)
    @if ($question->json['answer_type']!="txt")
    <?php
    $contadora = 0;
    ?>
    <div class="col-md-4 col-sm-4 col-xs-4">
    {{$contador}}
      <div class="container">
        <div class="row">
          @foreach ($question->json['answers'] as $answer)
          <div class="col-md-1 col-sm-1 col-xs-1" style="border: 1px solid gray; 
           @if ($answer['right'])
           background-color:red;
           @endif
          "><small> @if ($answer['right'])
          <b>{{chr($contadora+97)}}</b>
          @else
          {{chr($contadora+97)}}
           @endif</small></div>
          <?php
          $contadora++;
          ?>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    <?php
    $contador++;
    ?>
    @endforeach
  </div>
</div>

</body>
</html>