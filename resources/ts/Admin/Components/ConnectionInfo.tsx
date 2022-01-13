import * as React from 'react';
import { Component } from 'react';
import StatusIndicator from '../Components/StatusIndicator';

interface ConnectionInfoProps {
	status: boolean;
	user: any;
}

export default function ConnectionInfo( props: ConnectionInfoProps ) {
	return (
		<div>
			<StatusIndicator status={ props?.status } />
			{ props.status == true &&
				<div>
					<span>Connected As: </span>
					<span>
						<b>{`${ props.user?.name } ( ${ props.user?.oauth_user?.username } )` }</b>
					</span>
				</div>
			}
		</div>
	);
}
