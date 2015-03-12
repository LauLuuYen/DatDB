<div class="createthread">
    
    <div class="container2">
        <button ng-click="back()" class="btn">Back</button>
    </div>
    
    <div class="linebreak"></div>

    <div class="heading">Create New Thread</div>

    <div class="linebreak"></div>

    <form ng-submit="submit()">
        <div class="input_wrapper">
            <input type="text" ng-model="thread.title" ng-change="onChange('title_e')" placeholder="Title" maxlength="50"> </input>
            <span id="title_e" class="error invisible">Error: Please type in a title</span>
        </div>

        <div class="input_wrapper">
            <textarea cols="95" rows="3" class="input_text content" ng-model="thread.comment" ng-change="onChange('comment_e')" placeholder="Comment" maxlength="500"></textarea>
            <div id="comment_e" class="error invisible">Error: Please type in a comment</div>
            <br>
        </div>

        <div class="input_wrapper">
                <button id="submitbtn" type="submit" class="btn">Create</button>
        </div>

    </form>

</div>
