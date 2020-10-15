<?php

namespace QMILibs\StardustConnectClient\Event;

final class StardustConnectEvents
{
    /** Request */
    const BEFORE_REQUEST = 'stardust_connect_client.before_request';
    const REQUEST        = 'stardust_connect_client.request';
    const AFTER_REQUEST  = 'stardust_connect_client.after_request';

    /** Hydration */
    const BEFORE_HYDRATION = 'stardust_connect_client.before_hydration';
    const HYDRATE          = 'stardust_connect_client.hydrate';
    const AFTER_HYDRATION  = 'stardust_connect_client.after_hydration';
}