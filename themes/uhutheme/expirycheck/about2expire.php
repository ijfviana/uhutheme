<?php

/**
 * Template form for giving consent.
 *
 * Parameters:
 * - 'srcMetadata': Metadata/configuration for the source.
 * - 'dstMetadata': Metadata/configuration for the destination.
 * - 'yesTarget': Target URL for the yes-button. This URL will receive a POST request.
 * - 'yesData': Parameters which should be included in the yes-request.
 * - 'noTarget': Target URL for the no-button. This URL will receive a GET request.
 * - 'noData': Parameters which should be included in the no-request.
 * - 'attributes': The attributes which are about to be released.
 * - 'sppp': URL to the privacy policy of the destination, or FALSE.
 *
 * @package SimpleSAMLphp
 */

# netid will expire today
if ($this->data['daysleft'] == 0) {
    $this->data['header'] = $this->t(
        '{expirycheck:expwarning:warning_header_today}',
        [
            '%NETID%' => htmlspecialchars($this->data['netId'])
        ]
    );
    $warning = $this->t(
        '{expirycheck:expwarning:warning_today}',
        [
            '%NETID%' => htmlspecialchars($this->data['netId'])
        ]
    );
} elseif ($this->data['daysleft'] == 1) {
    # netid will expire in one day
    $this->data['header'] = $this->t(
        '{expirycheck:expwarning:warning_header}',
        [
            '%NETID%' => htmlspecialchars($this->data['netId']),
            '%DAYS%' => $this->t('{expirycheck:expwarning:day}'),
            '%DAYSLEFT%' => htmlspecialchars($this->data['daysleft']),
        ]
    );
    $warning = $this->t(
        '{expirycheck:expwarning:warning}',
        [
            '%NETID%' => htmlspecialchars($this->data['netId']),
            '%DAYS%' => $this->t('{expirycheck:expwarning:day}'),
            '%DAYSLEFT%' => htmlspecialchars($this->data['daysleft']),
        ]
    );
} else {
    # netid will expire in next <daysleft> days
    $this->data['header'] = $this->t(
        '{expirycheck:expwarning:warning_header}',
        [
            '%NETID%' => htmlspecialchars($this->data['netId']),
            '%DAYS%' => $this->t('{expirycheck:expwarning:days}'),
            '%DAYSLEFT%' => htmlspecialchars($this->data['daysleft']),
        ]
    );
    $warning = $this->t(
        '{expirycheck:expwarning:warning}',
        [
            '%NETID%' => htmlspecialchars($this->data['netId']),
            '%DAYS%' => $this->t('{expirycheck:expwarning:days}'),
            '%DAYSLEFT%' => htmlspecialchars($this->data['daysleft']),
        ]
    );
}

$this->data['autofocus'] = 'yesbutton';

$this->includeAtTemplateBase('includes/header_uhu.php');

?>

<form style="display: inline; margin: 0px; padding: 0px" action="<?php echo htmlspecialchars($this->data['yesTarget']); ?>">

    <div class="alert alert-danger" role="alert">

        <?php
        // Embed hidden fields...
        foreach ($this->data['yesData'] as $name => $value) {
            echo('<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />');
        }
        ?>
        <h3 class="alert-heading"> <?php echo $warning; ?></h3><hr>

        <p><?php echo $this->t('{expirycheck:expwarning:expiry_date_text}') . "<strong> " . $this->data['expireOnDate']; ?></strong></p>
        </div>

        <hr>

        <p class="mb-0" align="center"><input type="submit" name="yes" id="yesbutton" value="<?php echo htmlspecialchars($this->t('{expirycheck:expwarning:btn_continue}')) ?>" /></p>

</form>

</div>

<?php

$this->includeAtTemplateBase('includes/footer_uhu.php');
