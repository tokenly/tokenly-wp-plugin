import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface PromiseLinkProps {
	id: number,
}

interface PromiseLinkState {
	//
}

export default class PromiseLink extends Component<PromiseLinkProps, PromiseLinkState> {

	constructor( props: PromiseLinkProps ) {
		super( props );
	}

	render() {
		return (
			<span>
				<span>№ </span>
				<strong>
					<a href={ `/wp-admin/admin.php?page=tokenly-token-promise-show&promise=${ this.props.id }` }>
						{ this.props.id }
					</a>
				</strong>
			</span>
		);
	}
}
 

