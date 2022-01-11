import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

interface PromiseLinkProps {
	id: number,
}

interface PromiseLinkState {
	//
}

export default class PromiseLink extends Component<PromiseLinkProps, PromiseLinkState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: PromiseLinkProps ) {
		super( props );
	}

	render() {
		return (
			<span>
				<span>№ </span>
				<strong>
					<a href={ `${this.adminPageUrl}${this.namespace}-token-promise-show&promise=${ this.props.id }` }>
						{ this.props.id }
					</a>
				</strong>
			</span>
		);
	}
}
 

