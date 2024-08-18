<?php
/*
Template Name: Running Pace Calculator
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['contactForm'])) {
        // Set postSuccess to true - this will get set to false during validation if a value fails
        $postSuccess = true;
        
        // Validate the honeypot fields
        $honeyErr = false;
        if (strlen($_POST["website"]) > 0) {
            $honeyErr = true;
            $postSuccess = false;
        }

        // Validate first name has a value and is no longer than 50 characters
        $firstNameErr = false;
        $firstName = form_input_checks($_POST["firstName"]);
        if (!(strlen($firstName) > 0 && strlen($firstName) < 51)) {
            $firstNameErr = true;
            $postSuccess = false;
        }

        // Validate last name has a value and is no longer than 50 characters
        $lastNameErr = false;
        $lastName = form_input_checks($_POST["lastName"]);
        if (!(strlen($lastName) > 0 && strlen($lastName) < 51)) {
            $lastNameErr = true;
            $postSuccess = false;
        }

        // Validate the email address
        $emailErr = false;
        $email = form_input_checks($_POST["emailAddress"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $emailErr = true;
            $postSuccess = false;
        }

        // Get the phone number as a variable
        $phoneNumber = form_input_checks($_POST["phoneNumber"]);

        // Validate the contact reason
        $reasonErr = false;
        $reason = $_POST["reason"];
        if ($reason == "Choose a reason...") {
            $reasonErr = true;
            $postSuccess = false;
        }

        // Validate that the message has some content
        $messageErr = false;
        $message = form_input_checks($_POST["message"]);
        if (!(strlen($message) > 0 && strlen($message) < 5000)) {
            $messageErr = true;
            $postSuccess = false;
        }

        // Validate the reCaptcha
        $reCaptchaErr = false;
        $receivedRecaptcha = $_POST['g-recaptcha-response'];
        $verifiedRecaptcha = file_get_contents( 'https://www.google.com/recaptcha/api/siteverify?secret=' . RECAPTCHA_SECRETKEY . '&response=' . $receivedRecaptcha);
        $verResponseData = json_decode($verifiedRecaptcha);

        if( !$verResponseData->success ) {
            $reCaptchaErr = true;
            $postSuccess = false;
        }

        // If postSuccess is true at this stage then there has been no errors so far
        // so let's try and send the email
        $sendErr = false;
        if ($postSuccess == true) {
            $emailSubject = 'Website Contact Form - ' . $reason;
            $emailBody = 'Name: ' . $firstName . ' ' . $lastName;
            $emailBody = $emailBody . '<br /><br />Email Address: ' . $email;
            $emailBody = $emailBody . '<br /><br />Phone Number: ' . $phoneNumber;
            $emailBody = $emailBody . '<br /><br />Contact Reason: ' . $reason;
            $emailBody = $emailBody . '<br /><br />Message:<br />' . nl2br($message); 
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'Reply-To: ' . $firstName . ' ' . $lastName . ' <' . $email . '>';

            if (wp_mail(constant('CONTACT_EMAIL'), $emailSubject, $emailBody, $headers) == false) {
                $sendErr = true;
                $postSuccess = false;
            }
        }
    }
}
?>
<?php get_header(); ?>
<div class="page-content">
	<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-lg-none">
                    <img src="<?php echo get_template_directory_uri() ?>/img/contact.jpg" class="img-fluid mb-2" alt="Contact Us" />
                </div>
                <h1>Running Pace Calculator</h1>
                <figure class="d-lg-none <?php echo(isset($postSuccess)) ? 'd-none' : ''; ?> text-center">
                    <blockquote class="blockquote">
                        <p>"I don't know the future. I didn't come here to tell you how this is going to end. I came here to tell you how it's going to begin."</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Neo in <cite title="Source Title">The Matrix</cite>
                    </figcaption>
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php if ((isset($postSuccess)) && ($postSuccess == true)) : ?>
                    <div class="alert alert-success" role="alert">
                        Message successfully sent
                    </div>
                    <p>
                        Thank you for contacting Fit Dad. We have received your enquiry and one of our team will be in contact with you as soon
                        possible.
                    </p>
                <?php elseif ((isset($sendErr)) && ($sendErr == true)) : ?>
                    <div class="alert alert-danger" role="alert">
                        Oops! Something went wrong. There was a problem submitting your message.<br />
                        If this problem persists please contact us by telephone.
                    </div>
                <?php elseif ((isset($honeyErr)) && ($honeyErr == true)) : ?>
                    <div class="alert alert-danger" role="alert">
                        Oops! Something went wrong with the information you supplied.<br />
                        If this problem persists please contact us by telephone.
                    </div>
                <?php else : ?>
                    <?php if ((isset($postSuccess)) && ($postSuccess == false)) : ?>
                        <div class="alert alert-danger" role="alert">
                            There are errors on the form.<br />
                            Please correct the issues and re-submit.
                        </div>
                    <?php endif; ?>
                    <p>
                        <i>Your privacy is important to us. But in order to help you we do require some basic information. We will only use this information to 
                        facilitate your enquiry.</i>
                    </p>
                    <form id="paceForm" method="post" action="" novalidate class="mb-4 mb-lg-0">
                        <input type="hidden" name="paceCalculator" value="1" />
                        <div class="row">
                            <label class="form-label">Distance</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="distance" id="distance" class="form-control" placeholder="Distance" aria-label="Distance">
                            </div>
                            &nbsp;
                            <div class="col-4">
                                <select id="distanceType" name="distanceType" aria-describedby="distanceHelp" class="form-select <?php if (isset($distanceTypeErr)) { echo($distanceTypeErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                                    <option <?php if (!isset($distanceType) || $distanceType == 'Choose a distance...') echo('selected') ?>>Choose a distance...</option>
                                    <option <?php if (isset($distanceType) && $distanceType == 'Kilometres') echo('selected') ?>>Kilometres</option>
                                    <option <?php if (isset($distanceType) && $distanceType == 'Metres') echo('selected') ?>>Metres</option>
                                    <option <?php if (isset($distanceType) && $distanceType == 'Miles') echo('selected') ?>>Miles</option>
                                    <option <?php if (isset($distanceType) && $distanceType == 'Yards') echo('selected') ?>>Yards</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <small id="distanceHelp" class="form-text text-muted">Enter your distance</small>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-label">Time</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Hrs" aria-label="Hrs">
                            </div>
                            :
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Mins" aria-label="Mins">
                            </div>
                            :
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Secs" aria-label="Secs">
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-label">Pace</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Hrs" aria-label="Hrs">
                            </div>
                            :
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Mins" aria-label="Mins">
                            </div>
                            :
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Secs" aria-label="Secs">
                            </div>
                            <div class="col">
                                <select id="paceOption" name="paceOption" aria-describedby="paceOptionHelp" class="form-select <?php if (isset($paceOptionErr)) { echo($paceOptionErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                                    <option <?php if (!isset($paceOption) || $paceOption == 'Choose a pace...') echo('selected') ?>>Choose a pace...</option>
                                    <option <?php if (isset($paceOption) && $paceOption == 'per km') echo('selected') ?>>per km</option>
                                    <option <?php if (isset($paceOption) && $paceOption == 'per mile') echo('selected') ?>>per mile</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-6 mb-3 mb-md-0">
                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="firstName" id="firstName" aria-describedby="firstNameHelp" placeholder="Enter first name" value="<?php echo(isset($firstName)) ? $firstName : ''; ?>" class="form-control <?php if (isset($firstNameErr)) { echo($firstNameErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                                <small id="firstNameHelp" class="form-text text-muted">Please provide your first name</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lastName" id="lastName" aria-describedby="lastNameHelp" placeholder="Enter last name" value="<?php echo(isset($lastName)) ? $lastName : ''; ?>" class="form-control <?php if (isset($lastNameErr)) { echo($lastNameErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                                <small id="lastNameHelp" class="form-text text-muted">Please provide your last name</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="emailAddress" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" name="emailAddress" id="emailAddress" aria-describedby="emailAddressHelp" placeholder="Enter email address" value="<?php echo(isset($email)) ? $email : ''; ?>" class="form-control <?php if (isset($emailErr)) { echo($emailErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                            <small id="emailAddressHelp" class="form-text text-muted">Please provide your email address so that we can respond to you</small>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-6 mb-3 mb-md-0">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="text" name="phoneNumber" id="phoneNumber" aria-describedby="phoneNumberHelp" placeholder="Enter phone number" value="<?php echo(isset($phoneNumber)) ? $phoneNumber : ''; ?>" class="form-control <?php if (isset($phoneNumberErr)) { echo($phoneNumberErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                                <small id="phoneNumberHelp" class="form-text text-muted">Please provide your phone number</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reason" class="form-label">Contact Reason <span class="text-danger">*</span></label>
                                <select id="reason" name="reason" aria-describedby="reasonHelp" class="form-select <?php if (isset($reasonErr)) { echo($reasonErr == true) ? 'is-invalid' : 'is-valid'; } ?>">
                                    <option <?php if (!isset($reason) || $reason == 'Choose a reason...') echo('selected') ?>>Choose a reason...</option>
                                    <option <?php if (isset($reason) && $reason == 'General Enquiry') echo('selected') ?>>General Enquiry</option>
                                </select>
                                <small id="reasonHelp" class="form-text text-muted">Select the reason why you are contacting us</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea rows="5" name="message" id="message" aria-describedby="messageHelp" placeholder="Enter message" class="form-control <?php if (isset($messageErr)) { echo($messageErr == true) ? 'is-invalid' : 'is-valid'; } ?>"><?php echo(isset($message)) ? $message : ''; ?></textarea>
                            <small id="messageHelp" class="form-text text-muted">5000 character limit</small>
                        </div>
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITEKEY; ?>" data-callback="callbackCommentSubmit"></div>
				            <script type="text/javascript">
					            function callbackCommentSubmit() {
						            document.getElementById("submit-comment").removeAttribute("disabled");
					            }
				            </script>
                            <span style="color: #ff0000;"><?php if (isset($reCaptchaErr)) { echo($reCaptchaErr == true) ? 'reCaptcha not validated' : ''; } ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <img src="<?php echo get_template_directory_uri() ?>/img/contact.jpg" class="img-fluid mb-2" alt="Contact Us" />
                    <figure class="text-center">
                        <blockquote class="blockquote">
                            <p>"I don't know the future. I didn't come here to tell you how this is going to end. I came here to tell you how it's going to begin."</p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            Neo in <cite title="Source Title">The Matrix</cite>
                        </figcaption>
                    </figure>
                </div>
                <div class="row d-none">
                    <div class="col-7 col-md-6">
                        <h4>Opening Times</h4>
                        <table>
                            <tr>
                                <td>Monday</td>
                                <td rowspan="7">&nbsp;&nbsp;</td>
                                <td>08:00 - 16:30</td>
                            </tr>
                            <tr>
                                <td>Tuesday</td>
                                <td>08:00 - 16:30</td>
                            </tr>
                            <tr>
                                <td>Wednesday</td>
                                <td>08:00 - 16:30</td>
                            </tr>
                            <tr>
                                <td>Thursday</td>
                                <td>08:00 - 16:30</td>
                            </tr>
                            <tr>
                                <td>Friday</td>
                                <td>08:00 - 12:00</td>
                            </tr>
                            <tr>
                                <td>Saturday</td>
                                <td>Closed</td>
                            </tr>
                            <tr>
                                <td>Sunday</td>
                                <td>Closed</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-5 col-md-6">
                        <h4>Follow Us</h4>
                        <a href="https://www.facebook.com/North-East-Metal-Spinners-108728753962949" target="_blank">
                            <img src="<?php echo get_template_directory_uri() ?>/img/facebook_logo_512.png" class="img-fluid mb-2" style="width: 75px; height: auto;" alt="Follow us Facebook" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
			<div class="mt-4">
				<div class="advert-before">Advert</div>
				<div align="center">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- Fit Dad Square -->
						<ins class="adsbygoogle"
							style="display:block"
							data-ad-client="ca-pub-2933900882310913"
							data-ad-slot="9880151769"
							data-ad-format="auto"
							data-full-width-responsive="true"></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
				<div class="advert-after"></div>
			</div>
		</div>
    </div>
</div>
<?php get_footer(); ?>