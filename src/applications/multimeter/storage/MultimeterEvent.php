<?php

final class MultimeterEvent extends MultimeterDAO {

  const TYPE_STATIC_RESOURCE = 0;

  protected $eventType;
  protected $eventLabelID;
  protected $resourceCost;
  protected $sampleRate;
  protected $eventContextID;
  protected $eventHostID;
  protected $eventViewerID;
  protected $epoch;
  protected $requestKey;

  private $eventLabel;

  public function setEventLabel($event_label) {
    $this->eventLabel = $event_label;
    return $this;
  }

  public function getEventLabel() {
    return $this->eventLabel;
  }

  public static function getEventTypeName($type) {
    switch ($type) {
      case self::TYPE_STATIC_RESOURCE:
        return pht('Static Resource');
    }

    return pht('Unknown ("%s")', $type);
  }

  public static function formatResourceCost(
    PhabricatorUser $viewer,
    $type,
    $cost) {

    switch ($type) {
      case self::TYPE_STATIC_RESOURCE:
        return pht('%s Req', new PhutilNumber($cost));
    }

    return pht('%s Unit(s)', new PhutilNumber($cost));
  }


  protected function getConfiguration() {
    return array(
      self::CONFIG_TIMESTAMPS => false,
      self::CONFIG_COLUMN_SCHEMA => array(
        'eventType' => 'uint32',
        'resourceCost' => 'sint64',
        'sampleRate' => 'uint32',
        'requestKey' => 'bytes12',
      ),
      self::CONFIG_KEY_SCHEMA => array(
        'key_request' => array(
          'columns' => array('requestKey'),
        ),
        'key_type' => array(
          'columns' => array('eventType', 'epoch'),
        ),
      ),
    ) + parent::getConfiguration();
  }

}
