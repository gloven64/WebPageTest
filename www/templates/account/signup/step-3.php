<section class="payment-details">
    <div class="content">
        <h1>Payment Details</h1>
        <form method="POST" action="/signup" id="wpt-signup-paid-account">
            <?php include __DIR__ . '/../includes/chargify-payment-form.php'; ?>
            <input name="street-address" type="hidden" value="<?= $street_address ?>" data-chargify="address" required />
            <input name="city" type="hidden" value="<?= $city ?>" data-chargify="city" required />
            <input name="state" type="hidden" value="<?= $state_code ?>" data-chargify="state" required />
            <input name="country" type="hidden" value="<?= $country_code ?>" data-chargify="country" required />
            <input name="zipcode" type="hidden" value="<?= $zipcode ?>" required data-chargify="zip" />
            <input type="hidden" name="first-name" value="<?= $first_name ?>" />
            <input type="hidden" name="last-name" value="<?= $last_name ?>" />
            <input type="hidden" id="hidden-nonce-input" name="nonce" />
            <input type="hidden" name="email" value="<?= $email ?>" />
            <input type="hidden" name="company" value="<?= $company_name ?>" />
            <input type="hidden" name="password" value="<?= $password ?>" />
            <input type="hidden" name="plan" value="<?= $plan ?>" />
            <input type="hidden" name="step" value="3" />
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>" />

            <div class="form-input">
                <button type="submit">Sign Up</button>
            </div>

            <p class="disclaimer">By signing up I agree to WebPageTest's <a href="/terms.php" target="_blank" rel="noopener">Terms of Service</a> and <a href="https://www.catchpoint.com/trust#privacy" target="_blank" rel="noopener">Privacy Statement</a>.</p>
        </form>
    </div><!-- /.content -->
</section>
<aside>
    <h3>Selected Plan</h3>
    <div class="plan-name">
        <?= $is_plan_free ? "STARTER" : '<div class="heading wpt-pro-logo"> <span class="visually-hidden">WebPageTest <em class="new-banner">Pro</em></span></div>' ?>
    </div>
    <div class="plan-details">
        <table>
            <?php if (!$is_plan_free) : ?>
            <tr>
                <th>Pay Plan:</th>
                <td><?= $billing_frequency ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>Runs/mo:</th>
                <td><?= $runs ?? 300; ?></td>
            </tr>
            <tr>
                <th>Price:</th>
                <?php if ($is_plan_free) : ?>
                    <td>Free</td>
                <?php else : ?>
                    <?php if ($billing_frequency == "Monthly") : ?>
                        <td>$<?= "{$monthly_price}/mo" ?></td>
                    <?php else : ?>
                        <td><s>$<?= $other_annual ?></s> $<?= "{$annual_price}/yr" ?></td>
                    <?php endif; ?>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Estimated Taxes</th>
                <td><?= $estimated_tax ?? "--" ?></td>
            </tr>
            <tr>
                <th>Total including tax</th>
                <td><?= $total_including_tax ?? "--" ?></td>
            </tr>
            </tbody>
        </table>
    </div> <!-- /.plan-details -->
    <div class="plan-benefits">
        <h4>Plan Benefits</h4>
        <?php if ($is_plan_free) : ?>
            <ul>
                <li>Access to real browsers in real locations around the world, always running the latest versions.</li>
                <li>Testing on real connection speeds with gold-standard, accurate throttling.</li>
                <li>Custom scripting to let you interact with the page or script user journey flows.</li>
                <li>Access to test history for 13 months to allow for easy comparisons and over time.</li>
                <li>Opportunities report [NEW] to help you zero in on ways to improve the overall effectiveness of your websites.</li>
            </ul>
        <?php else : ?>
            <ul>
                <li>Everything in the Starter plan, including real browsers in real locations, custom scripting for page level and user journey measurements, access to 13 months of test history, and the all new Opportunities report to help you zero in on areas of improvement. </li>
                <li>Access to all new no-code Experiments </li>
                <li>API access for easier integration into your CI/CD, visualizations, alerting and more </li>
                <li>High priority tests to help you jump the queue and experience lower wait times </li>
                <li>Access to new and exclusive, premium-only, test locations </li>
                <li>Dedicated support to help you get back to work faster </li>
                <li>Bulk testing to enable testing of many pages at once </li>
                <li>Private tests for ensuring your private test results stay that way</li>
            </ul>
        <?php endif; ?>
    </div> <!-- /.plan-benefits -->
</aside>

<script>
  var hiddenNonceInput = document.querySelector('#hidden-nonce-input');
  var form = document.querySelector("#wpt-signup-paid-account");

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    var button = event.target.querySelector('button[type=submit]');
    button.disabled = true;
    button.setAttribute('disabled', 'disabled');
    button.innerText = 'Submitted';

    chargify.token(
        form,
        function success(token) {
            hiddenNonceInput.value = token;
            form.submit();
        },
        function error(err) {
            button.disabled = false;
            button.removeAttribute('disabled');
            button.innerText = 'Sign Up';
            console.log('token ERROR - err: ', err);
        }
    );
  });
</script>
