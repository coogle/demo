class app::database {

  class { '::mysql::server' :
     root_password => 'password'
  }
   
  mysql::db { 'demo':
    user => 'demo',
    password => 'demo',
    host => 'localhost'
  }
  
}
