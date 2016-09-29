<html>
<head></head>
<body>

<?php
 
  // Set default timezone
  date_default_timezone_set('UTC');
 
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:/var/www/databases/database.sqlite');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);

    echo "[DEBUG] Database stiMessenger.sqlite connected and opened ! </br>";
 
    /**************************************
    * Create tables                       *
    **************************************/
 
    // Create table users
    $file_db->exec("CREATE TABLE IF NOT EXISTS users (
                    user_id INTEGER PRIMARY KEY, 
                    user_name TEXT, 
                    user_pwd_hash TEXT, 
                    user_role INTEGER,
		    user_active INTEGER)");

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS messages (
                    message_id INTEGER PRIMARY KEY, 
                    message_subject TEXT, 
                    message_message TEXT, 
                    message_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		    message_sender_id INTEGER,
		    message_receiver_id INTEGER,
                    FOREIGN KEY (message_sender_id) REFERENCES users(user_id),
                    FOREIGN KEY (message_receiver_id) REFERENCES users(user_id))");

    echo "[DEBUG] Tables users and messages created ! </br>";
 
    /**************************************
    * Set initial data                    *
    **************************************/
 
    // Array with some test data to insert to database             
    $users = array(
                  array('user_name' => 'Thibault',
                        'user_pwd_hash' => 'thibault',
                        'user_role' => 0,
                        'user_active' => 1),

                  array('user_name' => 'Sebastien',
                        'user_pwd_hash' => 'sebastien',
                        'user_role' => 0,
                        'user_active' => 1),

                  array('user_name' => 'Bob',
                        'user_pwd_hash' => 'bob',
                        'user_role' => 1,
                        'user_active' => 1),

                );

    // Array with some test data to insert to database             
    $messages = array(
                  array('message_subject' => 'Hello',
                        'message_message' => 'Hello Thibault ! Just a little hello for testing.',
                        'message_sender_id' => 2,
                        'message_receiver_id' => 1),

                  array('message_subject' => 'What ?',
                        'message_message' => 'What are you testing ?',
                        'message_sender_id' => 1,
                        'message_receiver_id' => 2),

                  array('message_subject' => 'STI',
                        'message_message' => 'A crazy project for STI course.',
                        'message_sender_id' => 2,
                        'message_receiver_id' => 1),

                  array('message_subject' => 'OK',
                        'message_message' => 'Yeah, good luck, see you soon !.',
                        'message_sender_id' => 1,
                        'message_receiver_id' => 2),

                );
 
 
    /**************************************
    * Play with databases and tables      *
    **************************************/
 
    foreach ($users as $u) {
        // $formatted_time = date('Y-m-d H:i:s', $m['time']);
        $file_db->exec("INSERT INTO users (user_name, user_pwd_hash, user_role, user_active)
                VALUES ('{$u['user_name']}', '{$u['user_pwd_hash']}', '{$u['user_role']}', '{$u['user_active']}')");
    }

    foreach ($messages as $m) {
        // $formatted_time = date('Y-m-d H:i:s', $m['time']);
        $file_db->exec("INSERT INTO messages (message_subject, message_message, message_sender_id, message_receiver_id)
                VALUES ('{$m['message_subject']}', '{$m['message_message']}', '{$m['message_sender_id']}', '{$m['message_receiver_id']}')");
    }

    echo "[DEBUG] Tables users and messages initialized ! </br>";

   // $result =  $file_db->query('SELECT * FROM users');
   // foreach($result as $row) {
   // echo "user_id: " . $row['user_id'] . "</br>";
   //   echo "user_name: " . $row['user_name'] . "</br>";
   //   echo "user_pwd_hash: " . $row['user_pwd_hash'] . "</br>";
   //   echo "user_role: " . $row['user_role'] . "</br>";
   //   echo "user_active: " . $row['user_active'] . "</br>";
   //   echo "</br>";
   // }
 
 
    /**************************************
    * Drop tables                         *
    **************************************/
 
    // Drop table messages from file db
    //$file_db->exec("DROP TABLE users");
    //$file_db->exec("DROP TABLE messages");
    //echo "[DEBUG] Tables dropped ! </br>";

    // Remove database file
    //unlink('/var/www/databases/database.sqlite');
    //echo "[DEBUG] Database file removed ! </br>";
 
    /**************************************
    * Close db connections                *
    **************************************/
 
    // Close file db connection
    $file_db = null;

    echo "[DEBUG] Database connection closed ! </br>";
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

?>


</body>
</html>
