import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

interface GroupLinkProps {
	uuid: string,
	text?: boolean,
}

interface GroupLinkState {
	//
}

export default class GroupLink extends Component<GroupLinkProps, GroupLinkState> {
	@resolve( TYPES.Variables.adminUrl )
	adminUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: GroupLinkProps ) {
		super( props );
	}

	render() {
		const title = (
			<div>
				<span>№ </span>
				<strong>{ this.props.uuid }</strong>
			</div>
		);
		const url = `${ this.adminUrl }${ this.namespace }-credit-transaction-show&group=${ this.props.uuid }`;
		if ( this.props.text ) {
			return (
				<span>{ title }</span>
			)
		}
		return (
			<a href={ url }>{ title }</a>
		);
	}
}
 

