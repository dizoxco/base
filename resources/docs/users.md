## authenticate
authenticate must be configurable in laravel config files. authenticate can happen throgh sms, email and google.\
config items
- require (for sms and email)
- loginable (for sms, email and google)
- avalable (for sms, email and google)
- default method

### sms
users can register and login throgh throgh phone nomber and get verification codes on sms. all sms send from laravel chanels

### email
users can register and login throgh email. and rcive verifivation and reset link in email. all emails hav blade files in resources.

### google
users can register and login throgh google.

### ui
interface for login, register and remember password based on config for avalable methods and default method

## user private profile
profile

### ui
profile ui and navigation

## user manager in admin panel
## role manager in admin panel
## auhorize