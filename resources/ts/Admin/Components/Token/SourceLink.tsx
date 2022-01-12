import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

interface SourceLinkProps {
	id: string,
	label?: string,
	text?: boolean,
}

interface SourceLinkState {
	//
}

export default class SourceLink extends Component<SourceLinkProps, SourceLinkState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: SourceLinkProps ) {
		super( props );
	}

	render() {
		const title = this.props?.label ?? this.props.id;
		const url = `${this.adminPageUrl}${this.namespace}-token-source-show&source=${ this.props.id }`;
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
 

