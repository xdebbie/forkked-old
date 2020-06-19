<?php

class DAO
{
    protected $db;

    public function setDb($db)
    {
        $this->db = $db;
    }

    public function read_albums()
    {
        try {
            $id = 0;
            $query = $this->db->prepare('SELECT * FROM pitchfork WHERE score <= 6.0 ORDER BY score ASC, pubdate DESC');
            $query->execute([': id' => $id]);
            $rows = [];
            while ($row = $query->fetchObject()) {
                $rows[] = $row;
            }
            return $rows;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function filter_albums($score, $year, $genre)
    {
        $where_clause = '';

        if ($score != '') {
            $where_clause .= 'score LIKE :score and ';
        }
        if ($year != '') {
            $where_clause .= 'year LIKE :year and ';
        }
        if ($genre != '') {
            $where_clause .= 'genre = :genre and ';
        }
        try {
            $query = $this->db->prepare('SELECT * FROM pitchfork WHERE ".$where_clause." id > 0 ORDER BY score ASC, pubdate DESC');

            if ($score != '') {
                $query->bindParam(':score', $tempString = $score . '%', PDO::PARAM_STR);
            }
            if ($year != '') {
                $query->bindParam(':year', $tempString = '%' . $year, PDO::PARAM_STR);
            }
            if ($genre != '') {
                $query->bindParam(':genre', $genre, PDO::PARAM_STR);
            }

            $query->execute();
            $rows = [];
            while ($row = $query->fetchObject()) {
                $rows[] = $row;
            }
            return $rows;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function read_genres()
    {
        try {
            $id = 0;
            $query = $this->db->prepare('SELECT DISTINCT genre FROM pitchfork WHERE gente <> "" ORDER BY genre ASC, pubdate DESC');
            $query->execute();
            $rows = [];
            while ($row = $query->fetchObject()) {
                $rows[] = $row;
            }
            return $rows;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function read_years()
    {
        try {
            $id = 0;
            $query = $this->db->prepare('SELECT DISTINCT year FROM pitchfork WHERE year <> "" ORDER BY year DESC, pubdate DESC');
            $query->execute();
            $rows = [];
            while ($row = $query->fetchObject()) {
                $rows[] = $row;
            }
            return $rows;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
