import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

interface GroupLinkProps {
	uuid: string,
}

interface GroupLinkState {
	//
}

export default class GroupLink extends Component<GroupLinkProps, GroupLinkState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: GroupLinkProps ) {
		super( props );
	}

	render() {
		return(
			<div>
				<span>№ </span>
				<b>
					<span>{ this.props.uuid }</span>
				</b>
			</div>
		);
	}
}
 

