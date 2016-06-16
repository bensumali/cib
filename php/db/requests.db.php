<?php

    require_once("db/pdo.db.php");
    class RequestsDb
    {
        private $pdo;
        function RequestsDb()
        {
            $this->pdo = new PDOConnection();
        }
        function createRequest($message, $type, $user) {
            $result;
            try {

            }
            catch(PDOException $e) {

            }
        }
        function insertRequestIndex($username) {
            $result;
            try {
              $riq = $this->pdo->connection->prepare("INSERT INTO request_index(created_by) VALUES (:created_by)");
              $riq->bindParam(":created_by", $username, PDO::PARAM_STR);
              $riq->execute();
              $rir = $this->pdo->connection->lastInsertId();
              $result = $rir;
            }
            catch(PDOException $e) {
              error_log($e);
              $result = false;
            }
            return $result;
        }
        function insertRequest($index_id, $created_by) {
            $result;
            try {
              $rq = $this->pdo->connection->prepare("INSERT INTO request(index_id, created_by) VALUES(:index_id, :created_by)");
              $rq->bindParam(":index_id", $index_id, PDO::PARAM_INT);
              $rq->bindParam(":created_by", $created_by, PDO::PARAM_STR);
              $rq->execute();
              $result = $this->pdo->connection->lastInsertId();
            }
            catch(PDOException $e) {
              error_log($e);
              $result = false;
            }
            return $result;
        }
        function insertRequestContact(
          $requestIndexId,
          $requestId,
          $nameFirst,
          $nameMiddle,
          $nameLast,
          $title,
          $organizationName,
          $organizationType,
          $organizationDos,
          $addressStreet,
          $addressCity,
          $addressState,
          $addressZip,
          $email,
          $phone,
          $created_by
        ) {
            $result;
            try {
              $rcq = $this->pdo->connection->prepare("
                INSERT INTO request_contact(
                  index_id,
                  initial_request_id,
                  name_first,
                  name_middle,
                  name_last,
                  title,
                  organization_name,
                  organization_type,
                  organization_dos,
                  address_street,
                  address_city,
                  address_state,
                  address_zip,
                  email,
                  phone,
                  created_by)
                VALUES(
                  :index_id,
                  :initial_request_id,
                  :name_first,
                  :name_middle,
                  :name_last,
                  :title,
                  :organization_name,
                  :organization_type,
                  :organization_dos,
                  :address_street,
                  :address_city,
                  :address_state,
                  :address_zip,
                  :email,
                  :phone,
                  :created_by)
              ");
              $rcq->bindParam(":index_id", $requestIndexId, PDO::PARAM_INT);
              $rcq->bindParam(":initial_request_id", $requestId, PDO::PARAM_INT);
              $rcq->bindParam(":name_first", $nameFirst, PDO::PARAM_STR);
              $rcq->bindParam(":name_middle", $nameMiddle, PDO::PARAM_STR);
              $rcq->bindParam(":name_last", $nameLast, PDO::PARAM_STR);
              $rcq->bindParam(":title", $title, PDO::PARAM_STR);
              $rcq->bindParam(":organization_name", $organizationName, PDO::PARAM_STR);
              $rcq->bindParam(":organization_type", $organizationType, PDO::PARAM_STR);
              $rcq->bindParam(":organization_dos", $organizationDos, PDO::PARAM_STR);
              $rcq->bindParam(":address_street", $addressStreet, PDO::PARAM_STR);
              $rcq->bindParam(":address_city", $addressCity, PDO::PARAM_STR);
              $rcq->bindParam(":address_state", $addressState, PDO::PARAM_STR);
              $rcq->bindParam(":address_zip", $addressZip, PDO::PARAM_STR);
              $rcq->bindParam(":email", $email, PDO::PARAM_STR);
              $rcq->bindParam(":phone", $phone, PDO::PARAM_STR);
              $rcq->bindParam(":created_by", $created_by, PDO::PARAM_STR);
              $rcq->execute();
              $result = $this->pdo->connection->lastInsertId();
            }
            catch(PDOException $e) {
              error_log($e);
              $result = false;
            }
            return $result;
        }
        function insertRequestEvent(
          $requestIndexId,
          $requestId,
          $eventName,
          $eventDescription,
          $eventLocation,
          $eventDateStart,
          $eventDateEnd,
          $audienceStudent,
          $audienceStaff,
          $audienceFaculty,
          $audienceUci,
          $audienceOtherValue,
          $audienceOtherNumber,
          $audienceUnknown,
          $categoryAcademic,
          $categoryAcademicPreparation,
          $categoryEngagement,
          $categoryClubSports,
          $categoryGreekLife,
          $categoryHealthWellness,
          $categoryInternational,
          $categoryLeadership,
          $categoryLowIncome,
          $categoryMulticultural,
          $categoryPerformanceEntertainment,
          $categoryPolitical,
          $categoryProfessionalDevelopment,
          $categoryRecreation,
          $categoryReligious,
          $categoryService,
          $categorySocialSupport,
          $categoryValues,
          $categoryOther,
          $recognitionCampus,
          $recognitionOrangeCounty,
          $recognitionNational,
          $recognitionGlobal,
          $created_by
        ) {
          $result;
          try {
            $req = $this->pdo->connection->prepare("
              INSERT INTO request_event(
                index_id,
                initial_request_id,
                name,
                description,
                location,
                date_start,
                date_end,
                audience_student,
                audience_staff,
                audience_faculty,
                audience_uci,
                audience_other_value,
                audience_other_number,
                audience_unknown,
                category_academic,
                category_academic_preparation,
                category_engagement,
                category_club_sports,
                category_greek_life,
                category_health_wellness,
                category_international,
                category_leadership,
                category_low_income,
                category_multicultural,
                category_performance_entertainment,
                category_political,
                category_professional_development,
                category_recreation,
                category_religious,
                category_service,
                category_social_support,
                category_values,
                category_other,
                recognition_campus,
                recognition_orange_county,
                recognition_national,
                recognition_global,
                created_by)
              VALUES(
                :index_id,
                :initial_request_id,
                :name,
                :description,
                :location,
                :date_start,
                :date_end,
                :audience_student,
                :audience_staff,
                :audience_faculty,
                :audience_uci,
                :audience_other_value,
                :audience_other_number,
                :audience_unknown,
                :category_academic,
                :category_academic_preparation,
                :category_engagement,
                :category_club_sports,
                :category_greek_life,
                :category_health_wellness,
                :category_international,
                :category_leadership,
                :category_low_income,
                :category_multicultural,
                :category_performance_entertainment,
                :category_political,
                :category_professional_development,
                :category_recreation,
                :category_religious,
                :category_service,
                :category_social_support,
                :category_values,
                :category_other,
                :recognition_campus,
                :recognition_orange_county,
                :recognition_national,
                :recognition_global,
                :created_by)
            ");
            $req->bindParam(":index_id", $requestIndexId, PDO::PARAM_INT);
            $req->bindParam(":initial_request_id", $requestId, PDO::PARAM_INT);
            $req->bindParam(":name", $eventName, PDO::PARAM_STR);
            $req->bindParam(":description", $eventDescription, PDO::PARAM_STR);
            $req->bindParam(":date_start", $eventDateStart, PDO::PARAM_STR);
            $req->bindParam(":date_end", $eventDateEnd, PDO::PARAM_STR);
            $req->bindParam(":location", $eventLocation, PDO::PARAM_STR);
            $req->bindParam(":audience_student", $audienceStudent, PDO::PARAM_INT);
            $req->bindParam(":audience_staff", $audienceStaff, PDO::PARAM_INT);
            $req->bindParam(":audience_faculty", $audienceFaculty, PDO::PARAM_INT);
            $req->bindParam(":audience_uci", $audienceUci, PDO::PARAM_INT);
            $req->bindParam(":audience_other_value", $audienceOtherValue, PDO::PARAM_INT);
            $req->bindParam(":audience_other_number", $audienceOtherNumber, PDO::PARAM_INT);
            $req->bindParam(":audience_unknown", $audienceUnknown, PDO::PARAM_INT);
            $req->bindParam(":category_academic", $categoryAcademic, PDO::PARAM_INT);
            $req->bindParam(":category_academic_preparation", $categoryAcademicPreparation, PDO::PARAM_INT);
            $req->bindParam(":category_engagement", $categoryEngagement, PDO::PARAM_INT);
            $req->bindParam(":category_club_sports", $categoryClubSports, PDO::PARAM_INT);
            $req->bindParam(":category_greek_life", $categoryGreekLife, PDO::PARAM_INT);
            $req->bindParam(":category_health_wellness", $categoryHealthWellness, PDO::PARAM_INT);
            $req->bindParam(":category_international", $categoryInternational, PDO::PARAM_INT);
            $req->bindParam(":category_leadership", $categoryLeadership, PDO::PARAM_INT);
            $req->bindParam(":category_low_income", $categoryLowIncome, PDO::PARAM_INT);
            $req->bindParam(":category_multicultural", $categoryMulticultural, PDO::PARAM_INT);
            $req->bindParam(":category_performance_entertainment", $categoryPerformanceEntertainment, PDO::PARAM_INT);
            $req->bindParam(":category_political", $categoryPolitical, PDO::PARAM_INT);
            $req->bindParam(":category_professional_development", $categoryProfessionalDevelopment, PDO::PARAM_INT);
            $req->bindParam(":category_recreation", $categoryRecreation, PDO::PARAM_INT);
            $req->bindParam(":category_religious", $categoryReligious, PDO::PARAM_INT);
            $req->bindParam(":category_service", $categoryService, PDO::PARAM_INT);
            $req->bindParam(":category_social_support", $categorySocialSupport, PDO::PARAM_INT);
            $req->bindParam(":category_values", $categoryValues, PDO::PARAM_INT);
            $req->bindParam(":category_other", $categoryOther, PDO::PARAM_STR);
            $req->bindParam(":recognition_campus", $recognitionCampus, PDO::PARAM_INT);
            $req->bindParam(":recognition_orange_county", $recognitionOrangeCounty, PDO::PARAM_INT);
            $req->bindParam(":recognition_national", $recognitionNational, PDO::PARAM_INT);
            $req->bindParam(":recognition_global", $recognitionGlobal, PDO::PARAM_INT);
            $req->bindParam(":created_by", $created_by, PDO::PARAM_STR);
            $req->execute();
            $result = $this->pdo->connection->lastInsertId();
          }
          catch(PDOException $e) {
            error_log($e);
            $result = false;
          }
          return $result;
        }
        function insertRequestLearningOutcomes(
          $requestIndexId,
          $requestId,
          $statement,
          $domain,
          $created_by
        ) {
          $result;
          try {
            $rloq = $this->pdo->connection->prepare("
              INSERT INTO request_learning_outcomes(
                index_id,
                initial_request_id,
                statement,
                domain,
                created_by
              )
              VALUES (
                :index_id,
                :initial_request_id,
                :statement,
                :domain,
                :created_by
              )
            ");
            $rloq->bindParam(":index_id", $requestIndexId, PDO::PARAM_INT);
            $rloq->bindParam(":initial_request_id", $requestId, PDO::PARAM_INT);
            $rloq->bindParam(":statement", $statement, PDO::PARAM_STR);
            $rloq->bindParam(":domain", $domain, PDO::PARAM_STR);
            $rloq->bindParam(":created_by", $created_by, PDO::PARAM_STR);
            $rloq->execute();
            $result = true;
          }
          catch(PDOException $e) {
            error_log($e);
            $result = false;
          }
          return $result;
        }
        function insertRequestBudgetIndex(
          $requestIndexId,
          $created_by
        ) {
          $result;
          try {
            $rbiq = $this->pdo->connection->prepare("
              INSERT INTO request_budget_index(index_id, created_by)
              VALUES(:index_id, :created_by)
            ");
            $rbiq->bindParam(":index_id", $requestIndexId, PDO::PARAM_INT);
            $rbiq->bindParam(":created_by", $created_by, PDO::PARAM_STR);
            $rbiq->execute();
            return $this->pdo->connection->lastInsertId();
          }
          catch(PDOException $e) {
            error_log($e);
            return false;
          }
        }
        function insertRequestBudget(
          $requestBudgetIndexId,
          $requestId,
          $type,
          $name,
          $value,
          $createdBy
        ) {
          $result;
          try {
            $rbq = $this->pdo->connection->prepare("
              INSERT INTO request_budget(index_id, initial_request_id, type, name, value, created_by)
              VALUES(:index_id, :initial_request_id, :type, :name, :value, :created_by)
            ");
            $rbq->bindParam(":index_id", $requestBudgetIndexId, PDO::PARAM_INT);
            $rbq->bindParam(":initial_request_id", $requestId, PDO::PARAM_INT);
            $rbq->bindParam(":type", $type, PDO::PARAM_STR);
            $rbq->bindParam(":name", $name, PDO::PARAM_STR);
            $rbq->bindParam(":value", $value, PDO::PARAM_INT);
            $rbq->bindParam(":created_by", $createdBy, PDO::PARAM_STR);
            $rbq->execute();
            return $this->pdo->connection->lastInsertId();
          }
          catch(PDOException $e) {
            error_log($e);
            return false;
          }
        }
        function getRequests($index, $filters, $request_ids, $last_checked) {
            $limit = "";
            $idQuery = "";
            // Construct string that represents the request ids to be placed in the query
            if($request_ids) {
              $requestIdString = "(";
              foreach($request_ids as $k=>$v) {
                  $requestIdString .= $k . ", ";
              }
              $requestIdString .= "-1)";
              $currentTime = date("Y-m-d H:i:s", $last_checked);
              $idQuery = "AND r.index_id IN $requestIdString AND r.created_when >= '$currentTime'";
            }
            try {
                $result = array();
                $filterQuery = "";
                // Calculate the page to retrieve
                $requestsPerPage = 50;
                $offset = $index * $requestsPerPage;
                // If there are filters, then generate the fuzzy search terms
                if($filters) {
                  $filterQuery = "";
                  foreach($filters as $k=>$v) {
                    // If the filter type is string, then we need to do a fuzzy search based on it
                    if($v["value"]) {
                      if($v["type"] === "string") {
                        $fuzzyArray = $this->pdo->getLevenshtein($v["value"]);
                        $filterQuery .= " AND (";
                        foreach($fuzzyArray as $k1=>$v1) {
                          // After we get the array of fuzzy words, then we can form the appropriate query
                          if($k === "name_first")
                            $k = "rc." . $k;
                          $filterQuery .= " OR $k LIKE '%$v1%'";
                          if($filterQuery === " AND ( OR $k LIKE '%$v1%'")
                            $filterQuery = " AND ($k LIKE '%$v1%'";
                        }
                        $filterQuery .= ")";
                      }
                      else if($v["type"] === "number") {
                          if($k === "id")
                            $k = "rc.index_id";
                          $filterQuery .= " AND $k ". $v["comparator"] . " " . $v["value"];
                      }
                      else {
                        $filterQuery .= " AND $k " . $v["comparator"] . "'" . $v["value"] . "'";
                      }
                    }
                  }

                }
                $limit = "LIMIT $offset, $requestsPerPage";
                $q = "
                  SELECT
                    r.index_id, r.status, ri.created_when, r.awarded,
                    rc.name_first AS contact_name_first, rc.name_middle AS contact_name_middle, rc.name_last AS contact_name_last,
                    rc.organization_name AS contact_organization_name, rc.organization_type AS contact_organization_type, rc.organization_dos AS contact_organization_dos,
                    rc.title AS contact_title, rc.address_street AS contact_address_street, rc.address_city AS contact_address_city, rc.address_state AS contact_address_state, rc.address_zip AS contact_address_zip,
                    rc.email AS contact_email, rc.phone AS contact_phone,
                    re.name AS event_name, re.description AS event_description, re.location AS event_location,
                    re.date_start AS event_date_start, re.date_end AS event_date_end,
                    re.audience_student AS event_audience_student, re.audience_staff AS event_audience_staff,
                    re.audience_faculty AS event_audience_faculty, re.audience_uci AS event_audience_uci,
                    re.audience_other_value AS event_audience_other_value, re.audience_other_number AS event_audience_other_number,
                    re.audience_unknown AS event_audience_unknown,
                    re.category_academic AS event_category_academic, re.category_academic_preparation AS event_category_academic_preparation,
                    re.category_engagement AS event_category_engagement, re.category_club_sports AS event_category_club_sports, re.category_greek_life AS event_category_greek_life,
                    re.category_health_wellness AS event_category_health_wellness, re.category_international AS event_category_international, re.category_leadership AS event_category_leadership,
                    re.category_low_income AS event_category_low_income, re.category_multicultural AS event_category_multicultural,
                    re.category_performance_entertainment AS event_category_performance_entertainment, re.category_political AS event_category_political,
                    re.category_professional_development AS event_category_professional_development, re.category_recreation AS event_category_recreation,
                    re.category_religious AS event_category_religious, re.category_service AS event_category_service, re.category_social_support AS event_category_social_support,
                    re.category_values AS event_category_values, re.category_other AS event_category_other,
                    re.recognition_campus AS event_recognition_campus, re.recognition_orange_county AS event_recognition_campus, re.recognition_national AS event_recognition_national, re.recognition_global AS event_recognition_global,
                    rlo.statement AS learning_outcomes_statement, rlo.domain AS learning_outcomes_domain
                  FROM request AS r
                  JOIN request_index AS ri ON ri.id = r.index_id
                  JOIN request_contact AS rc on r.index_id = rc.index_id
                  JOIN request_event AS re ON r.index_id = re.index_id
                  JOIN request_learning_outcomes AS rlo ON r.index_id = rlo.index_id
                  WHERE r.removed_by IS NULL AND r.current = 1
                  AND rc.removed_by IS NULL AND rc.current=1
                  AND re.removed_by IS NULL AND re.current=1
                  AND rlo.removed_by IS NULL AND rlo.current=1
                  $idQuery
                  $filterQuery
                  $limit";
                $rq = $this->pdo->connection->prepare($q);
                $rq->execute();
                while($rr = $rq->fetch(\PDO::FETCH_ASSOC)) {
                  array_push($result, $rr);
                }
                if(count($result) === 0)
                  $result = "";
                return $result;
            }
            catch(PDOException $e) {
                error_log($e);
                return false;
            }
        }
        function checkForRequestUpdates($request_ids, $last_checked) {
            // Construct string that represents the request ids to be placed in the query
            $requestIdString = "(";
            foreach($request_ids as $k=>$v) {
                $requestIdString .= $k . ", ";
            }
            $requestIdString .= "-1)";
            $currentTime = date("Y-m-d H:i:s", $last_checked);

            try {
                $result = array();
                $rq = $this->pdo->connection->prepare("SELECT * FROM request WHERE removed_by IS NULL AND current = 1 AND index_id IN $requestIdString AND created_when >= '$currentTime'");

                $rq->execute();
                while($rr = $rq->fetch(\PDO::FETCH_ASSOC)) {
                  array_push($result, $rr);
                }
                return $result;
            }
            catch(PDOException $e) {
                error_log($e);
                return false;
            }
        }
        function getAdditionalRequestFields($arrayOfIndexIds) {
          try {
              $requestIdString = "(";
              foreach($arrayOfIndexIds as $k=>$v) {
                $requestIdString .= $v . ", ";
              }
              $requestIdString .= "-1)";
              $result = array();
              $req = $this->pdo->connection->prepare("
                SELECT rc.index_id AS request_index_id, rbi.id AS request_budget_index_id, *
                FROM request_contact AS r
                JOIN request_event AS re ON r.index_id = re.index_id
                JOIN request_learning_outcomes AS rlo ON r.index_id = rlo.index_id
                JOIN request_budget_index AS rbi ON r.index_id = rbi.index_id
                JOIN request_budget AS rb ON rb.index_id = rbi.id
                WHERE rc.index_id IN $requestIdString
                AND re.removed_by IS NULL AND rw.current=1
                AND rlo.removed_by IS NULL AND rlo.current=1
                AND rbi.removed_by IS NULL AND rbi.current=1
                AND rb.removed_by IS NULL AND rb.current=1
              ");
              $req->execute();
              while($rer = $req->fetch(\PDO::FETCH_ASSOC)) {
                array_push($result, $rer);
              }
              return $result;
          }
          catch(PDOException $e) {
            error_log($e);
            return false;
          }
        }
        function filterRequests($index, $filters) {
          $fields = "";
          $params = "";
          foreach($filters as $k=>$v) {
            // If the filter type is string, then we need to do a fuzzy search based on it
            if($v["type"] === "string") {
              $fields .= $v["field"] . ", ";
              $fuzzyArray = $this->pdo->getLevenshtein($v["value"]);
              foreach($fuzzyArray as $k1=>$v1) {
                // After we get the array of fuzzy words, then we can form the appropriate query

              }
            }
          }
        }
    }

?>
