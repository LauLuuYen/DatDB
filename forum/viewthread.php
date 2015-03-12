<div class="viewthread">

    <div class="container2">
        <button ng-click="back()" class="btn">Back</button>
    </div>
    
    <div class="linebreak"></div>

    <div class="heading"></div>

    <div class="container">
        <div class="comment">
            <div id="txt"></div><br>
            <div id="date">sdsgsgfgs</div>
            <div>(TODO add feature to delete comments)</div>
        </div>
    </div>

    <div class="linebreak"></div>


    <div class="container">

        <div dynamic="itemlist"></div>

    </div>

    <div class="container2">
        <form ng-submit="submit()">

            <div class="input_wrapper">
                <textarea cols="95" rows="3" class="input_text content" ng-model="thread.comment" ng-change="onChange('comment_e')" placeholder="New Comment" maxlength="500"></textarea>
                <div id="comment_e" class="error invisible">Error: Please type in a comment</div>
            </div>

            <div class="input_wrapper">
                    <button id="submitbtn" type="submit" class="btn">Create</button>
            </div>
        </form>
    </div>


</div>
