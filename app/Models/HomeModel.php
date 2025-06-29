<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $db; // 
    public function store($table, $data)
    {
        return $this->db->table($table)->insert($data);
    }
    public function __construct()
    {
        parent::__construct(); // ✅ Always call parent constructor first
        $this->db = \Config\Database::connect(); // ✅ Manual DB connection
    }
    public function getAuthors()
    {
        $query = $this->db->query("SELECT author_id, name, descriptions FROM authors");
        return $query->getResultArray();
    }

    public function update_auth($data)
    {
        // Wrap in array if not already batch
        if (!isset($data[0])) {
            $data = [$data];
        }
    
        return $this->db->table('authors')->updateBatch($data, 'author_id');
    }


    public function update_lib_user($data)
    {
        // Wrap in array if not already batch
        if (!isset($data[0])) {
            $data = [$data];
        }
    
        return $this->db->table('tbl_library_users')->updateBatch($data, 'lib_user_id');
    }
    public function delete_batch($data)
    {
        if (!isset($data[0])) {
            $data = [$data]; // Wrap single item
        }
    
        // Extract table name dynamically if embedded in data
        $table = 'authors'; // change if needed or pass as parameter
        $keyColumn = 'author_id'; // primary key
    
        // Extract only key values
        $ids = array_column($data, $keyColumn);
    
        return $this->db->table($table)->whereIn($keyColumn, $ids)->delete();
    }

    public function delete_lib_user($id)
    {
        return $this->db->table('tbl_library_users')->where('lib_user_id', $id)->delete();
    }
    

    public function getLibraryUsers()
    {
        $sql = "
            SELECT 
                tbl_library_users.lib_user_id, 
                tbl_library_users.username,

                tbl_library_users.email,
                gender,
                phone_number,
                occupation,
                dob,
                card_tag,
                tbl_library_users.image,
                tbl_library_users.status
            FROM tbl_library_users
        ";
    
        return $this->db->query($sql)->getResultArray();
    }

    

    public function getAllLoginLogs()
{
    $sql = "SELECT staff_id, ip_address, user_agent, device_type, platform, login_time 
            FROM login_logs 
            ORDER BY login_time DESC";
    return $this->db->query($sql)->getResult();
}


    public function get_libaray_user_id($id)
    {
        $sql = "
           SELECT lib_user_id, username,email,image FROM tbl_library_users WHERE card_tag=?
        ";
    
        return $this->db->query($sql, [$id])->getRowArray(); 
    }

    public function fetch_books()
    {
        $sql = "
           SELECT book_id,tbl_books.author_id,title,authors.Name,isbn,rfid_tag,quantity,published_year,price,photo,status,added_date from authors,tbl_books where authors.author_id=tbl_books.author_id
        ";
    
        return $this->db->query($sql)->getResultArray();
    }

    
    public function get_user_borrowed_receipt($card)
    {
        // Use a parameterized query to prevent SQL injection
        $sql = "
            SELECT 
                tbl_library_users.username,
                tbl_books.title,
                authors.Name,
                borrow.borrow_date,
                borrow.return_date
            FROM 
                borrow
            JOIN 
                tbl_books ON tbl_books.book_id = borrow.book_id
            JOIN 
                tbl_library_users ON tbl_library_users.card_tag = borrow.lib_user_id
            JOIN 
                authors ON authors.author_id = tbl_books.author_id
            WHERE 
                tbl_library_users.card_tag = ?";  // Use a placeholder for dynamic input
    
        return $this->db->query($sql, [$card])->getResultArray();  // Pass the $card value safely
    }
    
public function check_borrowed_rules($card)
{
    $sql = "
        SELECT COUNT(borrow.b_id) AS borrowed_count
        FROM borrow
        LEFT JOIN returend_books ON returend_books.boorow_id = borrow.b_id
        WHERE borrow.lib_user_id = ? AND returend_books.boorow_id IS NULL
    ";

    return $this->db->query($sql, [$card])->getRowArray();
}
public function get_balance_summary_by_user($user_id)
{
    $db = \Config\Database::connect();
    $query = $db->query("
        SELECT 
            (
                SELECT IFNULL(SUM(price), 0) FROM charge WHERE user_id = ?
            ) - (
                SELECT IFNULL(SUM(price), 0) FROM payment WHERE user_id = ?
            ) AS balance
    ", [$user_id, $user_id]);

    return $query->getRow()->balance ?? 0;
}


public function deleteChargeById($charge_id)
{
    $db = \Config\Database::connect();
    $sql = "DELETE FROM charge WHERE charge_id = ?";
    return $db->query($sql, [$charge_id]);
}


 public function Max_book_allowed()
{
    $sql = "SELECT max_books FROM library_policy LIMIT 1";
    $row = $this->db->query($sql)->getRowArray();
    return $row ? (int) $row['max_books'] : 1; // fallback to 1 if null
}

     public function getDamageCharges()
{
    $sql = "
        SELECT 
            charge.charge_id,
            tbl_books.title,
            authors.Name,
            tbl_library_users.username,
            tbl_library_users.card_tag,
            charge.charge_type,
            charge.price,
            charge.desriptions,
            charge.charge_date,
            charge.photo
        FROM 
            charge
        JOIN tbl_books ON tbl_books.book_id = charge.book_id
        JOIN authors ON authors.author_id = tbl_books.author_id
        JOIN tbl_library_users ON tbl_library_users.card_tag = charge.user_id
        WHERE 
            charge.charge_type = 'Damage'
        ORDER BY 
            charge.charge_id DESC
    ";

    return $this->db->query($sql)->getResult();
}




 public function book_price($book_id)
{
    $sql = "SELECT title, price FROM tbl_books WHERE book_id = ?";
    return $this->db->query($sql, [$book_id])->getRowArray();
}
public function get_return_date($book_id, $user_id)
{
    $sql = "SELECT borrow.return_date 
            FROM borrow
            LEFT JOIN returend_books ON borrow.b_id = returend_books.boorow_id
            WHERE borrow.book_id = ? 
              AND borrow.lib_user_id = ? 
              AND returend_books.boorow_id IS NULL";
    
    return $this->db->query($sql, [$book_id, $user_id])->getRowArray();
}

public function get_last_5_returned_books_with_optional_charges($user_id)
{
    $sql = "
        SELECT 
            tbl_books.title,
            authors.Name,
            borrow.borrow_date,
            borrow.return_date,
            returend_books.retuned_date,
            charge.price,
            charge.desriptions,
            charge.charge_date
        FROM borrow
        INNER JOIN tbl_books ON tbl_books.book_id = borrow.book_id
        INNER JOIN authors ON authors.author_id = tbl_books.author_id
        INNER JOIN returend_books ON returend_books.boorow_id = borrow.b_id
        LEFT JOIN charge ON charge.boorow_id = borrow.b_id
        WHERE borrow.lib_user_id = ?
        ORDER BY returend_books.retuned_date DESC
      
    ";

    return $this->db->query($sql, [$user_id])->getResultArray();
}

public function get_damaged_books_pending_charge()
{
    $sql = "
        SELECT 
            tbl_books.book_id,
            tbl_books.title,
            authors.Name AS author,
            borrow.b_id as borrow_id,

            tbl_books.price,
            tbl_books.photo,
            tbl_library_users.username,
            tbl_library_users.card_tag,
            returend_books.status
        FROM borrow
        INNER JOIN tbl_books ON tbl_books.book_id = borrow.book_id
        INNER JOIN authors ON authors.author_id = tbl_books.author_id
        INNER JOIN returend_books ON returend_books.boorow_id = borrow.b_id
        INNER JOIN tbl_library_users ON tbl_library_users.card_tag = borrow.lib_user_id
        WHERE returend_books.status = 'damaged'
        AND borrow.b_id NOT IN (
            SELECT boorow_id FROM charge WHERE charge_type = 'Damage'
        )
    ";

    return $this->db->query($sql)->getResultArray();
}

public function countBooks()
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT COUNT(book_id) AS total FROM tbl_books");
    $result = $query->getRow();

    return $result ? $result->total : 0;
}

public function countLibraryUsers()
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT COUNT(lib_user_id) AS total FROM tbl_library_users");
    $result = $query->getRow();

    return $result ? $result->total : 0;
}

public function countAuthors()
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT COUNT(author_id) AS total FROM authors");
    $result = $query->getRow();

    return $result ? $result->total : 0;
}
public function getLastRegisteredUsers()
{
    return $this->db->query("
        SELECT username, email, gender, phone_number, image, status,register_date
        FROM tbl_library_users
        ORDER BY lib_user_id DESC
        LIMIT 5
    ")->getResult();
}


public function get_unpaid_charges_by_user($user_id)
{
    $sql = "SELECT 
                charge.charge_id,
                tbl_books.title,
                authors.Name,
                borrow.borrow_date,
                borrow.return_date,
                returend_books.retuned_date,
                returend_books.status,

                charge.price AS total_charge,
                IFNULL(SUM(payment.price), 0) AS total_paid,
                (charge.price - IFNULL(SUM(payment.price), 0)) AS balance_due,
                charge.desriptions,
                charge.charge_date
            FROM borrow
            INNER JOIN tbl_books ON tbl_books.book_id = borrow.book_id
            INNER JOIN authors ON authors.author_id = tbl_books.author_id
            INNER JOIN returend_books ON returend_books.boorow_id = borrow.b_id
            LEFT JOIN charge ON charge.boorow_id = borrow.b_id
            LEFT JOIN payment ON payment.charge_id = charge.charge_id
            WHERE borrow.lib_user_id = ?
            GROUP BY charge.charge_id
            HAVING balance_due > 0
            ORDER BY returend_books.retuned_date DESC";

    return $this->db->query($sql, [$user_id])->getResultArray();
}

public function get_all_payments()
{
    $sql = "
        SELECT 
            payment.payment_id,
            tbl_library_users.username,
            tbl_library_users.card_tag,
            payment.price,
            charge.desriptions,
            payment.payment_method,
            payment.payment_date,
            payment.status
        FROM 
            payment
        JOIN charge ON charge.charge_id = payment.charge_id
        JOIN tbl_library_users ON tbl_library_users.card_tag = payment.user_id
    ";

    $query = $this->db->query($sql);
    return $query->getResultArray(); // use getResult() if you prefer objects
}

public function get_penalty_per_day()
{
    $sql = "SELECT penalty_per_day FROM library_policy";
    return $this->db->query($sql)->getRowArray();
}

    
    public function max_days_allowed ()
    {
        $sql = "SELECT max_days_allowed from library_policy";
        return $this->db->query($sql)->getRowArray(); // Return single row
    }
    
    
    
    public function updateData($table, $where, $data)
    {
        return $this->db->table($table)->update($data, $where);
    }


    public function getLibraryPolicy()
{
    $sql = "SELECT id, max_books, penalty_per_day,max_days_allowed, suspend_after_days,
                   minor_damage_fee, major_damage_fee, lost_book_fee,min_books_reserved,
                   delete_account_after_days, borrowing_note,damage_note, late_note
            FROM library_policy LIMIT 1";

    return $this->db->query($sql)->getRow();
}

public function get_unreturned_book($user_id, $book_id)
{
    $sql = "
        SELECT tbl_books.book_id, tbl_books.title, borrow.lib_user_id, returend_books.boorow_id 
        FROM tbl_books 
        JOIN borrow ON tbl_books.book_id = borrow.book_id 
        LEFT JOIN returend_books ON returend_books.boorow_id = borrow.b_id 
        WHERE borrow.lib_user_id = ? 
        AND tbl_books.book_id = ? 
        AND returend_books.boorow_id IS NULL
    ";

    return $this->db->query($sql, [$user_id, $book_id])->getResultArray();
}


public function get_libaray_for_books()
{
    $sql = "SELECT min_books_reserved FROM library_policy LIMIT 1";
    $row = $this->db->query($sql)->getRow();
    return $row ? (int) $row->min_books_reserved : 0;
}

public function decrement_book_quantity($book_id)
{
    $sql = "UPDATE tbl_books SET quantity = quantity -1 WHERE book_id = ?";
    return $this->db->query($sql, [$book_id]);
}


public function increment_book_quantity($book_id)
{
    $sql = "UPDATE tbl_books SET quantity = quantity + 1 WHERE book_id = ?";
    return $this->db->query($sql, [$book_id]);
}

public function get_book_details($id)
{
    $sql = "
        SELECT book_id, title, authors.Name, isbn, rfid_tag, published_year
        FROM tbl_books
        JOIN authors ON authors.author_id = tbl_books.author_id
        WHERE tbl_books.book_id = ?
    ";
    
    return $this->db->query($sql, [$id])->getRowArray();
}


public function get_library_policy()
{
    $sql = "SELECT id, max_books, max_days_allowed, penalty_per_day, suspend_after_days, 
                   minor_damage_fee, major_damage_fee, lost_book_fee, min_books_reserved 
            FROM library_policy 
            LIMIT 1";

    return $this->db->query($sql)->getRowArray(); // returns a single row as assoc array
}


 public function fetch_books_for_user()
{
    // Get the min reserved quantity
    $minReserved = $this->get_libaray_for_books(); // returns int

    $sql = "
        SELECT 
            tbl_books.book_id,
            tbl_books.title,
            authors.Name,
            authors.descriptions,
            tbl_books.published_year,
            tbl_books.photo,
            tbl_books.status
        FROM 
            tbl_books, authors
        WHERE 
            authors.author_id = tbl_books.author_id
            AND tbl_books.quantity > ?
    ";

    return $this->db->query($sql, [$minReserved])->getResultArray();
}


    public function checkDuplicateBook($title, $isbn, $year, $excludeId = null)
    {
        $sql = "SELECT * FROM tbl_books WHERE title = ? AND isbn = ? AND published_year = ?";
        $params = [$title, $isbn, $year];
    
        if ($excludeId) {
            $sql .= " AND book_id != ?";
            $params[] = $excludeId;
        }
    
        return $this->db->query($sql, $params)->getRowArray();
    }


    public function checkDuplicateISBN($isbn, $excludeId = null)
{
    $sql = "SELECT title FROM tbl_books WHERE isbn = ?";
    $params = [$isbn];

    if ($excludeId) {
        $sql .= " AND book_id != ?";
        $params[] = $excludeId;
    }

    return $this->db->query($sql, $params)->getRowArray();
}

    

    public function existing($id)
    {
        $sql = "SELECT image FROM tbl_library_users WHERE lib_user_id = ?";
        return $this->db->query($sql, [$id])->getRowArray(); // Use getRowArray for single row
    }


    public function update_Status($id, $status)
    {
        $sql = "UPDATE tbl_library_users SET status = ? WHERE lib_user_id = ?";
        return $this->db->query($sql, [$status, $id]);
    }
    
    public function checkDuplicateEmail($email, $excludeId = null)
{
    $builder = $this->db->table('tbl_library_users')->select('email')->where('email', $email);
    if ($excludeId) {
        $builder->where('lib_user_id !=', $excludeId);
    }
    return $builder->get()->getRowArray();
}

public function checkDuplicateCardTag($card_tag, $excludeId = null)
{
    $sql = "SELECT username, card_tag FROM tbl_library_users WHERE card_tag = ?";
    $params = [$card_tag];

    if ($excludeId) {
        $sql .= " AND lib_user_id != ?";
        $params[] = $excludeId;
    }

    return $this->db->query($sql, $params)->getRowArray();
}

public function checkDuplicateRFID($rfid_tag, $excludeId = null)
{
    $sql = "SELECT * FROM tbl_books WHERE rfid_tag = ?";
    $params = [$rfid_tag];

    if ($excludeId) {
        $sql .= " AND book_id != ?";
        $params[] = $excludeId;
    }

    return $this->db->query($sql, $params)->getRowArray();
}

public function getBookImageById($id)
{
    $sql = "SELECT photo FROM tbl_books WHERE book_id = ?";
    return $this->db->query($sql, [$id])->getRowArray();
}

public function update_book($data)
{
    return $this->db->table('tbl_books')->updateBatch($data, 'book_id');
}




public function update_rules($data)
{
    return $this->db->table('library_policy')->updateBatch($data, 'id');
}

public function insert_book($data)
{
    return $this->db->table('tbl_books')->insert($data);
}

public function delete_book($id)
{
    return $this->db->table('tbl_books')->where('book_id', $id)->delete();
}



public function get_authors()
{
    $sql = "
       SELECT author_id,Name from authors
    ";

    return $this->db->query($sql)->getResultArray();
}



public function get_libaray_staff()
    {
        $sql = "
            SELECT*from tbl_staff
        ";
    
        return $this->db->query($sql)->getResultArray();
    }
    public function delete_staff($id)
    {
        $sql = "DELETE FROM tbl_staff WHERE staff_id = ?";
        return $this->db->query($sql, [$id]);
    }
    public function update_Staff_Status($id, $status)
    {
        $sql = "UPDATE tbl_staff SET status = ? WHERE staff_id = ?";
        return $this->db->query($sql, [$status, $id]);
    }
    public function update_staff($data)
    {
        $sql = "UPDATE tbl_staff SET 
                    username = ?, 
                    password = ?, 
                    gender = ?, 
                    phone = ?, 
                    email = ?, 
                    address = ?, 
                    role = ?, 
                    image = ?, 
                    status = ?
                WHERE staff_id = ?";

        return $this->db->query($sql, [
            $data['username'],
            $data['password'],
            $data['gender'],
            $data['phone'],
            $data['email'],
            $data['address'],
            $data['role'],
            $data['image'],
            $data['status'],
            $data['staff_id']
        ]);
    }
    public function get_staff_image($id)
    {
        $sql = "SELECT image FROM tbl_staff WHERE staff_id = ?";
        return $this->db->query($sql, [$id])->getRowArray();
    }



public function get_book_quantity($book_id)
{
    $sql = "SELECT quantity FROM tbl_books WHERE book_id = ?";
    $row = $this->db->query($sql, [$book_id])->getRow();
    return $row ? (int) $row->quantity : 0;
}



    public function get_borrow_books($id)
    {
       $sql = "SELECT 
            borrow.b_id AS boorow_id,
            tbl_books.book_id,
            tbl_books.title,
            tbl_books.quantity,
            authors.Name,
            tbl_books.photo,
            tbl_books.published_year,
            borrow.borrow_date,
            borrow.return_date
        FROM 
            borrow
        JOIN 
            tbl_books ON borrow.book_id = tbl_books.book_id
        JOIN 
            authors ON tbl_books.author_id = authors.author_id
        LEFT JOIN 
            returend_books ON returend_books.boorow_id = borrow.b_id
        WHERE 
            borrow.lib_user_id = ? 
            AND returend_books.boorow_id IS NULL";

return $this->db->query($sql, [$id])->getResultArray();

    
    }

    public function get_users($email)
    {
        $sql = "
            SELECT lib_user_id, username, email, card_tag, image 
            FROM tbl_library_users 
            WHERE email = ?
        ";
    
        return $this->db->query($sql, [$email])->getResultArray();
    }
    

    public function get_unreturned_books_by_card($id)
{
    $sql = "
        SELECT  
            borrow.b_id,
            tbl_books.book_id,
            tbl_books.title,
            authors.Name,
            tbl_books.published_year,
            borrow.borrow_date,
            borrow.return_date,
            tbl_library_users.card_tag
        FROM 
            borrow
        JOIN 
            tbl_books ON borrow.book_id = tbl_books.book_id
        JOIN 
            authors ON tbl_books.author_id = authors.author_id
        JOIN 
            tbl_library_users ON borrow.lib_user_id = tbl_library_users.card_tag
        WHERE 
            borrow.b_id NOT IN (SELECT boorow_id FROM returend_books)
            AND tbl_library_users.card_tag = ?
        LIMIT 4
    ";

    return $this->db->query($sql, [$id])->getResultArray();
}

    
    
    
        
}
