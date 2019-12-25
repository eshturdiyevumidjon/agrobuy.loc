<?php

namespace common\models;

use Yii;

class PreferenceBooks
{
    public static function onLanguageChanged($event)
    {
        // $event->language: new language
        // $event->oldLanguage: old language

        // Save the current language to user record
        $session = Yii::$app->session;
        // Yii::$app->language = $event->language;
        $session['language'] = $event->language;
        // $user = Yii::$app->user;
        // if (!$user->isGuest) {
        //     $user->identity->language = $event->language;
        //     $user->identity->save();
        // }
    }

    public function getLanguageValue($key)
    {
        $session = Yii::$app->session;
    }
}