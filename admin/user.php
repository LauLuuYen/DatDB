<script>
    function showGroup(show) {
        if (show) {
            $("#groupsection").show();
        } else {
            $("#groupsection").hide();
        }
    }
</script>

<div class="createuser">
    <div class="heading">Create User</div>

    <div class="linebreak"></div>

    <div>Here you can create the user accounts for either a student or admin.</div>


    <!-- Create User form -->
    <form ng-submit="submit()">
    
        <div class="input_wrapper">
            First Name:
            <input type="text" class="input_text" ng-model="account.firstname" maxlength="40"></input>
            <div id="e1" class="error invisible">Error: Please type in the first name</div>
        </div>
        
        <div class="input_wrapper">
            Last Name:
            <input type="text" class="input_text" ng-model="account.lastname" maxlength="40"></input>
            <div id="e2" class="error invisible">Error: Please type in the last name</div>
        </div>
        
        <div class="input_wrapper">
            Email:
            <input type="email" class="input_text" ng-model="account.email" maxlength="100"></input>
            <div id="e3" class="error invisible">Error: Please type in the email address</div>
        </div>
        
        <div class="input_wrapper">
            Password:
            <input type="password" class="input_text" ng-model="account.password" maxlength="40"></input>
            <div id="e4" class="error invisible">Error: Please type in the password</div>
        </div>

        <div class="input_wrapper">
            User Role:<br>
            <label>
                <input type="radio" ng-model="account.role" value="student" onclick="showGroup(true)"> Student</input>
            </label><br>
            <label>
                <input type="radio" ng-model="account.role" value="admin" onclick="showGroup(false)"> Admin</input>
            </label>
            <div id="e5" class="error invisible">Error: Please select a user role</div>
        </div>

        <div id="groupsection" class="input_wrapper conceal">
            Select an available group:
            <select type="text" class="input_text" ng-model="account.grouplist"
                ng-options="item.name for item in grouplist"></select>
            <br>--or--<br>
            Assign the user to a new group:
            <input type="text" class="input_text" ng-model="account.groupname" maxlength="25"></input>
            <div id="e6" class="error invisible">Error: Please fill either of these entries</div>
        </div>
        
        
        <div class="input_wrapper">
            <button type="submit" >Create User</button>
        </div>
        
    </form>

</div>

