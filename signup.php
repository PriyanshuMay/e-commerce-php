<!DOCTYPE HTML
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="GNDEC GATE FORUM">
    <meta name="keywords" content="gate,gne,gndec,">
    <meta name="author"   content="PriyanshuMay,priyanshumay">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Register</title>
    <script language="javascript">
    function check()
    {
    if(document.signupform.pass.value!=document.signupform.cpass.value)
    {
    alert("Confirm Password does not matched");
      document.signupform.cpass.focus();
      return false;
    }
    e=document.signupform.email.value;
        f1=e.indexOf('@');
        f2=e.indexOf('@',f1+1);
        e1=e.indexOf('.');
        e2=e.indexOf('.',e1+1);
        n=e.length;
        if(!(f1>0 && f2==-1 && e1>0 && e2==-1 && f1!=e1+1 && e1!=f1+1 && f1!=n-1 && e1!=n-1))
        {
          alert("Please Enter valid Email");
          document.signupform.email.focus();
          return false;
        }
    return true;
    }
    
    </script>
    <style>
    html,body{
    padding: 0px;
    height: 85%;
    width: 100%;
    overflow: hidden;
    background-size:     cover;               
    background-repeat:   no-repeat;
    background-position: center;
    }
    .signupbox_signup {
    background: #fff;
    border-radius: 4px;
    padding-top: 2px;
    width: 380px;
    position: absolute;
    overflow-y: hidden;
    }
    </style>
    <link href="forum.css" rel="stylesheet" type="text/css">
  </head>
<body background="img/backgne.jpg">
<div class="signupbox_signup" style="position: absolute; top:5%;right:37%;">
      <center><br><br>
      <img class="img-circle" src="img/1.png"  width="200px" height="150px" style="position: relative; top:0%;"/>   
      </center>
      <center><table width="70%" border="0" style="padding: 15px;">
        <tr><td>
          <form name="signupform" method="post" action="signupuser.php" onSubmit="return check();">
            <tr>
              <td><input class="login_text_box" type="text" placeholder="Create Username" name="username"  required>
              </td>
            </tr>
            <tr>
              <td><input class="login_text_box" type="password" placeholder="Create Password" name="pass" required></td>
            </tr>
            <tr>
              <td><input class="login_text_box" name="cpass" placeholder="Confirm Password" type="password" id="cpass" required></td>
            </tr>
            <tr>
              <td><input class="login_text_box" type="text" name="name" placeholder="Full name" id="name" required></td>
            </tr>
            <tr>
              <td><input class="login_text_box" name="security" type="text" id="security"
              placeholder="Name of your childhood freind" required></td>
            </tr>
            <tr>
              <td><input class="login_text_box" name="phone" placeholder="+91" type="text" id="phone" required></td>
            </tr>
            <tr>
              <td><input class="login_text_box" name="email" type="text" placeholder="Enter valid e-mail" id="email" required></td>
            </tr>
            <td>&emsp;<input class="submit" type="submit" name="Submit" value="Signup">&emsp;</form>
          <button class="submit2" onclick="window.location.href = 'login.php';" >Already a Member</button></td>
        </tr>
      </table>
      </center>
      &emsp;&emsp;
    </div>
  </body>
</html>