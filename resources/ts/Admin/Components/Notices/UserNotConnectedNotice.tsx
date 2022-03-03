import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import { useState, useEffect } from 'react';

import { 
	Notice,
} from '@wordpress/components';

export default function UserNotConnectedNotice() {
	const brand: string = useInjection( TYPES.Variables.brand );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const isUserConnected: string = useInjection( TYPES.Variables.isUserConnected );
    const localStorageKey: string = `${namespace}-user-not-connected-notice-dismissed`;

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

    if ( !isUserConnected && !dismissed ) {
        return (
            <Notice
                status="warning"
                actions={
                    [
                        {
                            label: 'Connect',
                            url: `/wp-admin/profile.php#${namespace}`,
                        }
                    ]
                }
                //@ts-ignore
                onDismiss={ onDismiss }
            >
                { `User is not connected to the ${brand} network! Some of the services may be unavailable!` }
            </Notice>
        )
    } else {
        return null;
    }
}
 

