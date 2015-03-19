<div class="main">
    <div class="heading">Settings</div>
    <div class="linebreak"></div>
    <div>Blah blah blah beef</div><br>

    <div class="heading3">Change your password</div>

    <form class="cpw" ng-submit="submit()">
        <div class="input_wrapper">
            <div class="heading2">Old password:</div>
            <input type="password" class="input_text" ng-model="pw.o" maxlength=40
                ng-change="onChange('e1')"></input>
            <div id="e1" class="error invisible">Error: Please enter your old password</div>
        </div>
        <div class="input_wrapper">
            <div class="heading2">New password:</div>
            <input type="password" class="input_text" ng-model="pw.p1" maxlength=40
                ng-change="onChange('e2')"></input>
            <div id="e2" class="error invisible">Error: Please enter your new password</div>
            
            <div class="heading2">Confirm password:</div>
            <input type="password" class="input_text" ng-model="pw.p2" maxlength=40
                ng-change="onChange('e3')"></input>
            <div id="e3" class="error invisible">Error: Passwords do not match</div>
        </div>
        <button id="submit" type="submit">Change</div>
    </form>

</div>
