import * as React from 'react';
import { Component } from 'react';

interface SourceLinkProps {
	id: string,
	label?: string,
	text?: boolean,
}

interface SourceLinkState {
	//
}

export default class SourceLink extends Component<SourceLinkProps, SourceLinkState> {
	constructor( props: SourceLinkProps ) {
		super( props );
	}

	render() {
		const title = this.props?.label ?? this.props.id;
		const url = `/wp-admin/admin.php?page=tokenly-token-source-show&source=${ this.props.id }`;
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
 

