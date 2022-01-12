import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

interface GroupLinkProps {
	uuid: string,
	name?: string,
	text?: boolean,
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
		const title = this.props?.name ?? this.props.uuid;
		const url = `${ this.adminPageUrl }${ this.namespace }-credit-group-show&group=${ this.props.uuid }`;
		if ( this.props.text ) {
			return (
				<b><span>{ title }</span></b>
			)
		}
		return (
			<b><a href={ url }>{ title }</a></b>
		);
	}
}
 

