import * as React from 'react';
import { Component } from 'react';

import { 
	 Flex,
	 Dashicon,
} from '@wordpress/components';

interface UserLinkProps {
	id: number;
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

	getUserUrl( id: number = null ) {
		if ( id ) {
			return `/tokenly/user/${ id }`;
		} else {
			return false;
		}
	}

	render() {
		return (
			<div>
				<Dashicon icon="admin-users" style={ { marginRight: '2px' } } />
				<strong title={ this.props.alt }>
					<a href={ this.getUserUrl( this.props.id ) as any } >
						<span>{this.props.name ? this.props.name : 'unknown' }</span>
					</a>
				</strong>
			</div>
		);
	}
}
 

