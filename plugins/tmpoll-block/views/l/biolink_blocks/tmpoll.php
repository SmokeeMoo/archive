<?php defined('ALTUMCODE') || die() ?>

<style>
    
    
    h2 {
    color: #1da1f2;
    }
    
    .form-group_<?= $data->link->biolink_block_id ?> {
    margin-bottom: 20px;
    }
    
    
    label_<?= $data->link->biolink_block_id ?> {
    font-weight: normal;
    color: <?= $data->link->settings->text_color ?>;
    background: <?= $data->link->settings->background_color ?>;
    cursor: pointer;
    display: block;
    padding: 10px;
    border: 1px solid <?= $data->link->settings->background_color ?>;
    border-radius: 36px;
    transition: background-color 0.5s ease;
    }
    
    label<?= $data->link->biolink_block_id ?>:hover {
    opacity: 0.6;
    }
    
    input[type="radio"] {
    //display: none;
    }
    
    .result {
    margin-top: 20px;
    }
    
    .progress-title_<?= $data->link->biolink_block_id ?>{
    font-size: inherit;
    font-weight: normal;
    color: <?= $data->link->settings->text_color ?>;
    margin: 0 0 5px 10px;
    text-align: left;
    }
    .progress{
    height: 20px;
    line-height: 15px;
    border-radius: 20px;
    background: #ffffff10;
    margin-bottom: 15px;
    box-shadow: none;
    overflow: visible;
    }
    .progress .progress-bar{
    position: relative;
    border-radius: 20px;
    animation: animate-positive 2s;
    }
    .progress .progress-value{
    display: block;
    font-size: 13px;
    color: #fff;
    position: absolute;
    top: 2px;
    right: 8px;
    }
    @-webkit-keyframes animate-positive{
    0% { width: 0%; }
    }
    @keyframes animate-positive{
    0% { width: 0%; }
    }
    
    
    
    
</style>

<div id="biolink_block_id_<?= $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" class="col-11 my-2" style="background: <?= $data->link->settings->border_color ?>; border-radius: 5px; padding: 2rem; margin: 0 auto;">
    
    <form id="votingForm_<?= $data->link->biolink_block_id ?>">
        <?php foreach ($data->link->settings->items as $key => $item): ?>
        <div class="form-group" style="margin: 1rem 0;" data-biolink-block-id="<?= $data->link->biolink_block_id ?>">
            <label_<?= $data->link->biolink_block_id ?> for="option<?= $key ?>" onclick="submitVote(this, <?= $key ?>)" class="link-hover-animation link-btn-round  animate__animated animate__repeat-1 animate__false animate__delay-2s"><?= $item->title ?></label>
            <input type="radio" style="display:none;" name="vote" id="option<?= $key ?>" value="<?= $key ?>" required>
            <div class="percentage-container">
                <div class="percentage" id="percentage<?= $key ?>"></div>
            </div>
        </div>
        <?php endforeach ?>
    </form>
    
    <div class="result" id="resultSection_<?= $data->link->biolink_block_id ?>"></div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        function submitVote(element, option) {
            var biolinkBlockId = element.closest('.form-group').getAttribute('data-biolink-block-id');
            
            if (!getCookie("voted_" + biolinkBlockId)) {
                var formData = new FormData();
                formData.append('vote', option);
                formData.append('biolinkBlockId', biolinkBlockId);
                
                fetch('/source/php/vote.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    //  alert(data.message);
                    setCookie("voted_" + biolinkBlockId, "true", 1);
                    displayResults_<?= $data->link->biolink_block_id ?>(biolinkBlockId);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                } else {
                alert('Have you already voted.');
            }
        }
        
        function displayResults_<?= $data->link->biolink_block_id ?>(biolinkBlockId) {
            var formData = new FormData();
            formData.append('biolinkBlockId', biolinkBlockId);
            fetch('/source/php/getvote.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(results => {
                var resultsContainer = document.getElementById('resultSection_' + biolinkBlockId);
                if (!resultsContainer) {
                    resultsContainer = document.createElement('div');
                    resultsContainer.id = 'resultSection_' + biolinkBlockId;
                    document.body.appendChild(resultsContainer);
                    } else {
                    resultsContainer.innerHTML = '';
                }
                
                results.forEach(result => {
                    var totalVotes = results.reduce((sum, r) => sum + parseInt(r.votes, 10), 0);
                    var percentage = totalVotes > 0 ? Math.round((parseInt(result.votes, 10) / totalVotes) * 100) : 0;
                    var resultBlock = document.createElement('div');
                    resultBlock.className = 'container';
                    resultBlock.innerHTML = `
                    <div class="row">
                    <div class="col-md-12" style="margin-bottom: 1rem;">
                <h3 class="progress-title_<?= $data->link->biolink_block_id ?>">${result.title}</h3>
                <div class="progress">
                    <div class="progress-bar" style="width: ${percentage}%; background: <?= $data->link->settings->background_color ?>;">
                        <div class="progress-value">${percentage}%</div>
                    </div>
                </div>
            </div>
        </div>
        `;
        resultsContainer.appendChild(resultBlock);
        });
        hideVoteFields(biolinkBlockId);
        })
        .catch(error => {
        console.error('Error:', error);
        });
        }
        
        function hideVoteFields(biolinkBlockId) {
        var voteFields = document.querySelectorAll('.form-group[data-biolink-block-id="' + biolinkBlockId + '"]');
        voteFields.forEach(field => {
        field.style.display = 'none';
        });
        }
        
        function setCookie(name, value, days) {
        var expires = "";
        var period = <?= $data->link->settings->period ?> * 24 * 60 * 60 * 1000
        if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * period));
        expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
        }
        
        function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
        }
        window.onload = function () {
        var blocks = document.querySelectorAll('[data-biolink-block-id]');
        blocks.forEach(block => {
            var blockId = block.getAttribute('data-biolink-block-id');
            if (getCookie("voted_" + blockId)) {
            displayResults_<?= $data->link->biolink_block_id ?>(blockId);
            }
            });
            };
        </script>
    </div>
    
    
