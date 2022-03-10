import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface ConnectionActionsProps {
	status: boolean;
	disabled: boolean;
}

export default function ConnectionActions( props: ConnectionActionsProps ) {
	const brand = useInjection( TYPES.Variables.brand );
	const namespace = useInjection( TYPES.Variables.namespace );

	const [ connecting, setConnecting ] = useState( false );
	const [ disconnecting, setDisconnecting ] = useState( false );

	function resetStorage(): void {
		localStorage.removeItem( `${namespace}-user-not-connected-notice-dismissed` );
	}

	function onConnectButtonClick() {
		resetStorage();
		setConnecting( true );
	}

	function onDisconnectButtonClick() {
		resetStorage();
		setDisconnecting( true );
	}

	return (
		<Flex justify='flex-start'>
			<Button
				isSecondary
				isBusy={ connecting }
				disabled={ ( props.status || props.disabled ) }
				href={ `/${namespace}/oauth/connect?${namespace}_success_url=/wp-admin/profile.php#${namespace}` }
				onClick={ onConnectButtonClick }
			>
				{ `Connect to ${brand}` }
			</Button>
			<Button
				isDestructive
				isBusy={ disconnecting }
				disabled={ ( !props.status || props.disabled ) }
				href={ `/${namespace}/oauth/disconnect?${namespace}_success_url=/wp-admin/profile.php#${namespace}` }
				onClick={ onDisconnectButtonClick }
			>
				{ `Disconnect from ${brand}` }
			</Button>
		</Flex>
	);
}
 

