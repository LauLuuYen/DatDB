<div class="createuser">
    <!-- Create User form -->
    <form ng-submit="submit()">
    
        <div class="input_wrapper">
            First Name
            <input type="text" class="input_text" ng-model="account.firstname">
        </div>
        
        <div class="input_wrapper">
            Last Name
            <input type="text" class="input_text" ng-model="account.lastname">
        </div>
        
        <div class="input_wrapper">
            Email
            <input type="text" class="input_text" ng-model="account.email">
        </div>
        
        <div class="input_wrapper">
            Password
            <input type="password" class="input_text" ng-model="account.password">
        </div>
        
        <div class="input_wrapper">
            Groupname
            <input type="text" class="input_text" ng-model="account.groupname">
        </div>
        
        
        <div class="input_wrapper">
            <button type="submit" >Create User</button>
        </div>
        
    </form>

</div>

