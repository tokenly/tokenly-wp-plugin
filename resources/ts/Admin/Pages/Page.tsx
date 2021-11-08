import * as React from 'react';
import { Component } from 'react';

import { 
	Fragment,
} from '@wordpress/element';

interface PageProps {
	title: string,
	children: any;
}

interface PageState {
	//
}

export default class Page extends Component<PageProps, PageState> {
	state: PageState = {
		//
	};
	constructor( props: PageProps ) {
		super( props );
	}
	
	render() {
		return (
			<Fragment>
				<h2>{ this.props.title }</h2>
				{ this.props.children }
			</Fragment>
		)
	}
}
