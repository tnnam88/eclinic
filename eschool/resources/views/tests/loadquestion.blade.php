<div class="card">
    <div class="card-header" <?php echo "id='heading$quest->id'"?>>
        <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" <?php echo "data-target='#collapse$quest->id'"?> aria-expanded="true" <?php echo "aria-controls='collapse$quest->id'"?>>
                {{$quest->content}}
            </button>
        </h5>
    </div>

    <div <?php echo "id='collapse$quest->id'"?> class="collapse" <?php echo "aria-labelledby='heading$quest->id'"?> data-parent="#accordion">
        <div class="card-body">

            <ol>
                @php
                    $answers = DB::table('answers')->where('question_id',$quest->id)
                       ->inRandomOrder()
                       ->get();
                    foreach($answers as $answer) {
                    echo "<li><label class='radiocontainer'>$answer->content
                   <input type='radio' name='$quest->id' value='$answer->id'
                   /><span class='checkmark'></span></label></li>";

                   }
                @endphp
            </ol>
        </div>
    </div>
</div>