<?php
require_once '../lib/Phirehose.php';
require_once '../lib/OauthPhirehose.php';
require_once 'twitter-auth-config.php';

/**
 * Example of how to update filter predicates using Phirehose
 */
class DynamicTrackConsumer extends OauthPhirehose
{
    /**
     * Subclass specific attribs
     */
    protected $myTrackWords = ['morning', 'goodnight', 'hello', 'the'];

    /**
     * Enqueue each status
     *
     * @param string $status
     */
    public function enqueueStatus($status)
    {
        // We won't actually do anything with statuses in this example, see updateFilterPredicates() for important stuff
    }

    /**
     * In this example, we just set the track words to a random 2 words. In a real example, you'd want to check some sort
     * of shared medium (ie: memcache, DB, filesystem) to determine if the filter has changed and set appropriately. The
     * speed of this method will affect how quickly you can update filters.
     */
    public function checkFilterPredicates()
    {
        // This is all that's required, Phirehose will detect the change and reconnect as soon as possible
        $randWord1 = $this->myTrackWords[rand(0, 3)];
        $randWord2 = $this->myTrackWords[rand(0, 3)];
        $this->setTrack([$randWord1, $randWord2]);
    }
}

// Start streaming
$sc = new DynamicTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->consume();
