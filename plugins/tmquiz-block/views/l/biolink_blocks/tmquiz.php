<?php defined('ALTUMCODE') || die() ?>


<style>
    
    #title {
    text-decoration: underline;
    }
    
    #quiz {
    text-indent: 10px;
    display:none;
    }
    
    .button {
    border-radius: 3px;
    width: 45%;
    padding-left: 5px;
    padding-right: 5px;
    position: relative;
    background-color: #DCDCDC;
    color: black;
    margin: 0 auto;
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    }
    
    .button.active {
    background-color: #F8F8FF;
    color: #525252;
    }
    
    button {
    position: relative;
    float:right;
    }
    
    .button a {
    text-decoration: none;
    color: black;
    }
    
    #container_<?= $data->link->biolink_block_id ?> {
    margin:auto;
    padding: 1rem;
    background-color: <?= $data->link->settings->background_color ?>;
    border-radius:5px;
    color: <?= $data->link->settings->text_color ?>;
    }
    
    ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    margin-bottom: 1rem;
    text-align: left;
    margin-left: 1rem;
    }
    
    #prev {
    display:none;
    }
    
    #start {
    display:none;
    width: 45%;
    }
    
</style>


<div id="<?= 'biolink_block_id_' . $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" class="col-12 my-2">
    
    
    <div id='container_<?= $data->link->biolink_block_id ?>'>
        <div id='quiz'></div>
        <div class='button' id='next'><a href='#'><?= l('create_biolink_tmquiz_modal.next') ?></a></div>
        <div class='button' id='prev'><a href='#'><?= l('create_biolink_tmquiz_modal.prev') ?></a></div>
        <div class='button' id='start'> <a href='#'><?= l('create_biolink_tmquiz_modal.start_over') ?></a></div>
        
    </div>
    
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
    
    <script>
        (function () {
            var questions = [
            <?php foreach($data->link->settings->items as $key => $item): ?>
            {
                question: "<?= $item->title ?>",
                choices: [<?php if( strlen($item->content1) > 0) { ?>'<?= $item->content1 ?>'<?php } ?> <?php if( strlen($item->content2) > 0) { echo ','; ?>'<?= $item->content2 ?>'<?php } ?> <?php if( strlen($item->content3) > 0) { echo ','; ?>'<?= $item->content3 ?>'<?php } ?> <?php if( strlen($item->content4) > 0) { echo ',';?>'<?= $item->content4 ?>'<?php } ?>, <?php if( strlen($item->content5) > 0) { ?>'<?= $item->content5 ?>'<?php } ?>],
                correctAnswer: <?= $item->true_answer ?>-1
            },
            <?php endforeach ?>
            
            ];
            
            var questionCounter = 0;
            var selections = [];
            var quiz = $("#quiz");
            
            displayNext();
            
            $("#next").on("click", function (e) {
                e.preventDefault();
                
                if (quiz.is(":animated")) {
                    return false;
                }
                choose();
                
                if (isNaN(selections[questionCounter])) {
                    alert("<?= l('create_biolink_tmquiz_modal.alert') ?>");
                    } else {
                    questionCounter++;
                    displayNext();
                }
            });
            
            $("#prev").on("click", function (e) {
                e.preventDefault();
                
                if (quiz.is(":animated")) {
                    return false;
                }
                choose();
                questionCounter--;
                displayNext();
            });
            
            $("#start").on("click", function (e) {
                e.preventDefault();
                
                if (quiz.is(":animated")) {
                    return false;
                }
                questionCounter = 0;
                selections = [];
                displayNext();
                $("#start").hide();
            });
            
            $(".button").on("mouseenter", function () {
                $(this).addClass("active");
            });
            $(".button").on("mouseleave", function () {
                $(this).removeClass("active");
            });
            
            function createQuestionElement(index) {
                var qElement = $("<div>", {
                    id: "question"
                });
                
                var header = $("<h4><?= l('create_biolink_tmquiz_modal.title_question') ?> " + (index + 1) + ":</h4>");
                qElement.append(header);
                
                var question = $("<p>").append(questions[index].question);
                qElement.append(question);
                
                var radioButtons = createRadios(index);
                qElement.append(radioButtons);
                
                return qElement;
            }
            
            function createRadios(index) {
                var radioList = $("<ul>");
                var item;
                var input = "";
                for (var i = 0; i < questions[index].choices.length; i++) {
                    item = $("<li>");
                    input = '<input class="form-check-input" type="radio" name="answer" value=' + i + " />";
                    input += questions[index].choices[i];
                    item.append(input);
                    radioList.append(item);
                }
                return radioList;
            }
            
            function choose() {
                selections[questionCounter] = +$('input[name="answer"]:checked').val();
            }
            
            function displayNext() {
                quiz.fadeOut(function () {
                    $("#question").remove();
                    
                    if (questionCounter < questions.length) {
                        var nextQuestion = createQuestionElement(questionCounter);
                        quiz.append(nextQuestion).fadeIn();
                        if (!isNaN(selections[questionCounter])) {
                            $("input[value=" + selections[questionCounter] + "]").prop(
                            "checked",
                            true
                            );
                        }
                        
                        if (questionCounter === 1) {
                            $("#prev").show();
                            } else if (questionCounter === 0) {
                            $("#prev").hide();
                            $("#next").show();
                        }
                        } else {
                        var scoreElem = displayScore();
                        quiz.append(scoreElem).fadeIn();
                        $("#next").hide();
                        $("#prev").hide();
                        $("#start").show();
                    }
                });
            }
            
            function displayScore() {
                var score = $("<p>", { id: "question" });
                
                var numCorrect = 0;
                for (var i = 0; i < selections.length; i++) {
                    if (selections[i] === questions[i].correctAnswer) {
                        numCorrect++;
                    }
                }
                
                score.append(
                "<?= l('create_biolink_tmquiz_modal.you_got') ?> " +
                numCorrect +
                " <?= l('create_biolink_tmquiz_modal.questions_out_of') ?> " +
                questions.length +
                " <?= l('create_biolink_tmquiz_modal.right') ?>"
                );
                return score;
            }
        })();
    </script>
    
</div>
