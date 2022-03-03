import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import { useState, useEffect } from 'react';

import { 
	Notice,
} from '@wordpress/components';

export default function IntegrationNotConnectedNotice() {
	const brand: string = useInjection( TYPES.Variables.brand );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const isIntegrationConnected: string = useInjection( TYPES.Variables.isIntegrationConnected );
    const localStorageKey: string = `${namespace}-integration-not-connected-notice-dismissed`;

    const [ dismissed, setDismissed ] = useState<boolean>( false );

    useEffect( () => {
        let dismissedStored: string = localStorage.getItem( localStorageKey );
        dismissedStored = JSON.parse( dismissedStored );
		setDismissed( dismissedStored as unknown as boolean );
	}, [] );

    function onDismiss(): void {
        setDismissed( true );
        localStorage.setItem( localStorageKey, 'true' );
    }

    if ( !isIntegrationConnected && !dismissed ) {
        return (
            <Notice
				status="warning"
				actions={
					[
						{
							label: 'Connect',
							url: `/wp-admin/admin.php?page=${namespace}-settings`,
						}
					]
				}
				//@ts-ignore
				onDismiss={ onDismiss }
			>
				{ `Integration is not connected to the ${brand} network! Some of the services may be unavailable!` }
            </Notice>
        )
    } else {
        return null;
    }
}
 

