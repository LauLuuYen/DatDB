<div class="createuser">
    <div class="heading">Create User</div>

    <div class="linebreak"></div>

    <div>Here you can create the user accounts for either a student or admin.</div>


    <!-- Create User form -->
    <form ng-submit="submit()">
    
        <div class="input_wrapper">
            First Name
            <input type="text" class="input_text" ng-model="account.firstname"></input>
            <div class="error">Error: Please type in the first name</div>
        </div>
        
        <div class="input_wrapper">
            Last Name
            <input type="text" class="input_text" ng-model="account.lastname"></input>
            <div class="error">Error: Please type in the last name</div>
        </div>
        
        <div class="input_wrapper">
            Email
            <input type="text" class="input_text" ng-model="account.email"></input>
            <div class="error">Error: Please type in the email address</div>
        </div>
        
        <div class="input_wrapper">
            Password
            <input type="password" class="input_text" ng-model="account.password"></input>
            <div class="error">Error: Please type in the password</div>
        </div>

        <div class="input_wrapper">
            User Role<br>
            <input type="radio" ng-model="account.role" value="student"> Student</input><br>
            <input type="radio" ng-model="account.role" value="admin"> Admin</input>
            <div class="error">Error: Please select a user role</div>
        </div>

        <div class="input_wrapper">
            Select an available group
            <select type="text" class="input_text" ng-model="account.grouplist"
                ng-options="item.name for item in grouplist"></select>
            <br>--or--<br>
            Assign user to a new group
            <input type="text" class="input_text" ng-model="account.groupname"></input>
            <div class="error">Error: Please fill either of these entries</div>
        </div>
        
        
        <div class="input_wrapper">
            <button type="submit" >Create User</button>
        </div>
        
    </form>

</div>

