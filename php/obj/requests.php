<?php

    require_once("db/requests.db.php");
    require_once("obj/logs.php");
    require_once("inc/PHPMailerAutoload.php");
    class Requests
    {
        public $requestsDb;
        public $logs;
        function Requests() {
            $this->requestsDb = new RequestsDb();
            $this->logs = new Logs();
        }
        function createRequest($form, $username) {
            $result = array();
            $result["result"];
            $result["error"];
            // $l = $this->logsDb->insertLog($message, $type, $user);
            // First create a request index
            $ri = $this->requestsDb->insertRequestIndex($username);
            if(!$ri) {
                // If there was an error creating the request index, then we need to inform the user and mark down the error in our log
                $message = "There was a problem creating your request. Please contact Student Affairs IT.";
                $this->logs->createLog("Could not create request for user '$username'", "error");
                $result["error"] = $message;
            }
            else {
                // If the creation of the request was successful, then we can continue and add the corresponding request records and tie it to the request index
                // First we need to format some of the fields that we are going to be inputting into the record
                $organizationDos = 0;
                $audienceStudent = 0;
                $audienceStaff = 0;
                $audienceFaculty = 0;
                $audienceUci = 0;
                $audienceOtherValue = "";
                $audienceOtherNumber = 0;
                $audienceUnknown = 0;

                $categoryAcademic = 0;
                $categoryAcademicPreparation = 0;
                $categoryEngagement = 0;
                $categoryClubSports = 0;
                $categoryGreekLife = 0;
                $categoryHealthWellness = 0;
                $categoryInternational = 0;
                $categoryLeadership = 0;
                $categoryLowIncome = 0;
                $categoryMulticultural = 0;
                $categoryPerformanceEntertainment = 0;
                $categoryPolitical = 0;
                $categoryProfessionalDevelopment = 0;
                $categoryRecreation = 0;
                $categoryReligious = 0;
                $categoryService = 0;
                $categorySocialSupport = 0;
                $categoryValues = 0;
                $categoryOther = "";
                $recognitionCampus = 0;
                $recognitionOrangeCounty = 0;
                $recognitionNational = 0;
                $recognitionGlobal = 0;

                if($form["contact"]["organization_dos"])
                  $organizationDos = 1;
                if($form["event"]["audience"]["student"]["checked"])
                  $audienceStudent = $form["event"]["audience"]["student"]["number"];
                if($form["event"]["audience"]["staff"]["checked"])
                  $audienceStaff = $form["event"]["audience"]["staff"]["number"];
                if($form["event"]["audience"]["faculty"]["checked"])
                  $audienceFaculty = $form["event"]["audience"]["faculty"]["number"];
                if($form["event"]["audience"]["uci"]["checked"])
                  $audienceUci = $form["event"]["audience"]["uci"]["number"];
                if($form["event"]["audience"]["other"]["checked"]) {
                  $audienceOtherNumber = $form["event"]["audience"]["other"]["number"];
                  $audienceOtherValue = $form["event"]["audience"]["other"]["value"];
                }
                if($form["event"]["audience"]["unknown"]["checked"])
                  $audienceUnknown = 1;


                if($form["event"]["category"]["academic"])
                  $categoryAcademic = 1;
                if($form["event"]["category"]["academic_preparation"])
                  $categoryAcademicPreparation = 1;
                if($form["event"]["category"]["engagement"])
                  $categoryEngagement = 1;
                if($form["event"]["category"]["club_sports"])
                  $categoryClubSports = 1;
                if($form["event"]["category"]["greek_life"])
                  $categoryGreekLife = 1;
                if($form["event"]["category"]["health_wellness"])
                  $categoryHealthWellness = 1;
                if($form["event"]["category"]["international"])
                  $categoryInternational = 1;
                if($form["event"]["category"]["leadership"])
                  $categoryLeadership = 1;
                if($form["event"]["category"]["low_income"])
                  $categoryLowIncome = 1;
                if($form["event"]["category"]["multicultural"])
                  $categoryMulticultural = 1;
                if($form["event"]["category"]["performance_entertainment"])
                  $categoryPerformanceEntertainment = 1;
                if($form["event"]["category"]["political"])
                  $categoryPolitical = 1;
                if($form["event"]["category"]["professional_development"])
                  $categoryProfessionalDevelopment = 1;
                if($form["event"]["category"]["recreation"])
                  $categoryRecreation = 1;
                if($form["event"]["category"]["religious"])
                  $categoryReligious = 1;
                if($form["event"]["category"]["service"])
                  $categoryService = 1;
                if($form["event"]["category"]["social_support"])
                  $categorySocialSupport = 1;
                if($form["event"]["category"]["values"])
                  $categoryValues = 1;
                if($form["event"]["category"]["other"]["checked"])
                  $categoryOther = $form["event"]["category"]["other"]["value"];

                if($form["event"]["recognition"]["campus"])
                  $recognitionCampus = 1;
                if($form["event"]["recognition"]["orange_county"])
                  $recognitionOrangeCounty = 1;
                if($form["event"]["recognition"]["national"])
                  $recognitionNational = 1;
                if($form["event"]["recognition"]["global"])
                  $recognitionGlobal = 1;

                // $this->logs->createLog("User '$username' created a request.", "action");
                // First, let's create the request record
                $r = $this->requestsDb->insertRequest($ri, $username);
                if($r) { // If the creation of the request record was successful, then let's try inserting the contact information next.
                  $rc = $this->requestsDb->insertRequestContact(
                    $ri,
                    $r,
                    $form["contact"]["name_first"],
                    $form["contact"]["name_middle"],
                    $form["contact"]["name_last"],
                    $form["contact"]["title"],
                    $form["contact"]["organization_name"],
                    $form["contact"]["organization_type"],
                    $form["contact"]["organization_dos"],
                    $form["contact"]["address_street"],
                    $form["contact"]["address_city"],
                    $form["contact"]["address_state"],
                    $form["contact"]["address_zip"],
                    $form["contact"]["email"],
                    $form["contact"]["phone"],
                    $username
                  );
                  // $result["success"] = $form["event"];
                  if($rc) {
                    // If the contact information was successfully inserted, then we can move on to the event info
                    $re = $this->requestsDb->insertRequestEvent(
                      $ri,
                      $r,
                      $form["event"]["name"],
                      $form["event"]["description"],
                      $form["event"]["location"],
                      $form["event"]["date_start"],
                      $form["event"]["date_end"],
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
                      $username
                    );
                    if($re) {
                        // If the event information was successfully recorded, then record the learning outcomes
                        $rlo = $this->requestsDb->insertRequestLearningOutcomes(
                          $ri,
                          $r,
                          $form["learning_outcomes"]["statement"],
                          $form["learning_outcomes"]["domain"],
                          $username
                        );
                        if($rlo) {
                            // After the learning outcomes have been successfully recorded, then we can start to record budget results
                            // Loop through all the budget items
                            $error = false; // Flag used to indicate if a budget record was not successfully created
                            //Go through each category of budgeting
                            foreach($form["budget"] as $k=>$v) {
                              // Only go through this iteration if the item is not the total amount requested
                              if($k != "amount_requested") {
                                // If the budget group is not from additional funding, then change the loop to the format given by budget items
                                $type = $k;
                                if($k !== "other_funding") {
                                    $loop = $v["saved"];
                                }
                                else { // If the group is from funding_other...
                                    $loop = $v;
                                }
                                foreach($loop as $k1=>$v1) {
                                  if($k === "other_funding") {
                                        $type = "funding_" . $k1;
                                  }
                                  if($k1 === "other") {
                                    // Loop through all the additional funding sources
                                    foreach($v1 as $k2=>$v2) {
                                      $item = $v2["item"];
                                      $cost = $v2["cost"];
                                      $rbi = $this->requestsDb->insertRequestBudgetIndex(
                                        $ri,
                                        $username
                                      );
                                      if($rbi) {
                                        if($v2["cost"] !== "" && $v2["item"] !== "") {
                                          $rb = $this->requestsDb->insertRequestBudget(
                                            $rbi,
                                            $r,
                                            $type,
                                            $item,
                                            $cost,
                                            $username
                                          );
                                          if(!$rb) {
                                            $result["error"] = "Could not create a record for your budget proposal. Please contact Student Affairs if problems continue to persist.";
                                            $error = true;
                                            $this->logs->createLog("User '$username' failed to create a budget record.", "error");
                                            break;
                                          }
                                        }
                                      }
                                      else {
                                          $result["error"] = "Could not create an index for your budget proposal. Please contact Student Affairs if problems continue to persist.";
                                          $error = true;
                                          $this->logs->createLog("User '$username' failed to create a budget index.", "error");
                                          break;
                                      }
                                    // End of the loop through additional funding
                                    }
                                  }
                                  else {
                                    $item = $v1["item"];
                                    $cost = $v1["cost"];
                                    // First insert a budget index record to track changes of each budget item
                                    $rbi = $this->requestsDb->insertRequestBudgetIndex(
                                      $ri,
                                      $username
                                    );
                                    if($rbi) {
                                      if($v1["cost"] !== "" && $v1["item"] !== "") {
                                        $rb = $this->requestsDb->insertRequestBudget(
                                          $rbi,
                                          $r,
                                          $type,
                                          $item,
                                          $cost,
                                          $username
                                        );
                                        if(!$rb) {
                                          $result["error"] = "Could not create a record for your budget proposal. Please contact Student Affairs if problems continue to persist.";
                                          $error = true;
                                          $this->logs->createLog("User '$username' failed to create a budget record.", "error");
                                          break;
                                        }
                                      }
                                    }
                                    else {
                                        $result["error"] = "Could not create an index for your budget proposal. Please contact Student Affairs if problems continue to persist.";
                                        $error = true;
                                        $this->logs->createLog("User '$username' failed to create a budget index.", "error");
                                        break;
                                    }
                                  }
                                }
                              }
                              else { // If the budget item is the total amount requested
                                $rbi = $this->requestsDb->insertRequestBudgetIndex(
                                  $ri,
                                  $username
                                );
                                if($rbi) {
                                  $rb = $this->requestsDb->insertRequestBudget(
                                    $rbi,
                                    $r,
                                    "amount_requested",
                                    "Amount Requested",
                                    $v,
                                    $username
                                  );
                                  if(!$rb) {
                                    $result["error"] = "Could not create a record for your budget proposal. Please contact Student Affairs if problems continue to persist.";
                                    $error = true;
                                    $this->logs->createLog("User '$username' failed to create a budget record for the total amount requested.", "error");
                                  }
                                }
                                else {
                                    $result["error"] = "Could not create an index for your budget proposal. Please contact Student Affairs if problems continue to persist.";
                                    $error = true;
                                    $this->logs->createLog("User '$username' failed to create a budget index for the total amount requested.", "error");
                                }
                              }
                              if($error) {
                                break;
                              }
                            // End of the budget items loop
                            }
                            if(!$error) {
                              // If we successfully added all the budget items, we can then send an email detailing the success
                              // TODO: Send email
                              $mail = new PHPMailer;
                              $mail->isSMTP();
                              $mail->SMTPDebug = 0;
                              $mail->Host = "plover.vcsa.uci.edu";
                              $mail->SMTPAuth = true;
                              $mail->Username = 'studentaffairs@plover.vcsa.uci.edu';
                              $mail->Password = 'miiacm03';
                              $mail->SMTPSecure = 'tls';
                              $mail->Port = 25;
                              $beginning_html = "
                                  <h1>We have received your funding request.</h1>
                                  <p>You can view the status of your request by clicking <a href='http://" . $_SERVER['HTTP_HOST'] . "/funding/'>here</a></p>
                                  <br />
                                  <br />
                                  <p>Student Affairs Support Team</p>
                              ";
                              $beginning_alt = "

                              ";


                              $mail->setFrom('studentaffairs-noreply@uci.edu');
                              $mail->addAddress($form["contact"]["email"]);
                              $mail->isHTML(true);
                              $mail->Subject = 'Funding Request Confirmation';
                              $mail->Body    = $beginning_html;



                              $mail->AltBody =  $beginning_alt;

                              if(!$mail->send()) {
                                  error_log("Could not send confirmation email for request submission to '$username'.");
                                  error_log('Mailer Error: ' . $mail->ErrorInfo);
                                  $this->logs->createLog("Could not send confirmation email for request submission to '$username'.", "error");
                                  $result["error"] = "Your submission was successfully sent, however, there was an issue sending your confirmation email.";
                              } else {
                                  $this->logs->createLog("User '$username' submitted new request.", "action");
                                  $result["result"] = $form;
                              }
                            }
                        }
                        else {
                            $result["error"] = "Could not record your learning outcome information. Please contact Student Affairs if problems continue to persist.";
                        }
                    }
                    else {
                        $result["error"] = "Could not record your event information. Please contact Student Affairs if problems continue to persist.";
                    }
                  }
                  else {
                    $result["error"] = "Could not record your contact information. Please contact Student Affairs if problems continue to persist.";
                  }
                }
                else {
                  $result["error"] = "Could not create request. Please contact Student Affairs if problems continue to persist.";
                }
            }
            return $result;
        }
        function getRequests($index, $filters) {
            $result = array();
            $result["result"];
            $result["error"];
            $r = $this->requestsDb->getRequests($index, $filters);
            if($r || $r === "") {
              // If we successfully got all the reqeust records, then we can get the additional records as well
              $result["result"] = array();
              $result["result"] = $r;
              // $ra = $this->requestsDb->getAdditionalRequestFields($idArray);
              // // Then after we get the additional fields, we need to loop through and insert that data into the data we are passing back to the client
              // foreach($ra as $k=>$v) {
              //   array_push($result["result"][$v["request_index_id"]], $v);
              // }
            }
            else {
              $result["error"] = "There was an issue retrieving the requests. Please contact Student Affairs IT.";
            }
            return $result;
        }
        function checkForRequestUpdates($request_ids, $lastChecked) {
            $result = array();
            $result["result"];
            $result["error"];
            $r = $this->requestsDb->getRequests(0, 0, $request_ids, $lastChecked);
            if($r || count($r) == 0 || $r === "") {
              $result["result"] = $r;
            }
            else{
              $result["error"] = "There was an issue retrieving updates for your requests. Please contact Student Affairs IT.";
            }
            return $result;
        }
    }



?>
