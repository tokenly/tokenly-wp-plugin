import * as React from 'react';
import { Component } from 'react';
import StatusIndicator from '../Components/StatusIndicator';

interface ConnectionInfoProps {
	status: boolean;
	user: any;
}

interface ConnectionInfoState {
	//
}

export default class ConnectionInfo extends Component<ConnectionInfoProps, ConnectionInfoState> {

	constructor( props: ConnectionInfoProps ) {
		super( props );
	}

	getStatusText() {
		let status = 'Not connected';
		if ( this.props.status === true ) {
			status = 'Connected';
		}
		return status;
	}

	render() {
		return (
			<div>
				<StatusIndicator status={ this.props?.status } />
				{ this.props.status == true &&
					<div>
						<span>Connected as: </span>
						<span>
							<strong>{`${ this.props.user?.name } ( ${ this.props.user?.oauth_user?.username } )` }</strong>
						</span>
					</div>
				}
			</div>
		);
	}
}
 

