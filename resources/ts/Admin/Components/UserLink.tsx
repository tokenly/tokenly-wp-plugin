import * as React from 'react';
import { Component } from 'react';

import { 
	 Dashicon,
} from '@wordpress/components';

interface UserLinkProps {
	url: string;
	alt: string;
	name: string;
}

interface UserLinkState {
	//
}

export default class UserLink extends Component<UserLinkProps, UserLinkState> {

	constructor( props: UserLinkProps ) {
		super( props );
	}

	render() {
		return (
			<div>
				<Dashicon icon="admin-users" style={ { marginRight: '2px' } } />
				<strong title={ this.props.alt }>
					<a href={ this.props.url } >
						<span>{ this.props.name ? this.props.name : 'Unknown' }</span>
					</a>
				</strong>
			</div>
		);
	}
}
 

