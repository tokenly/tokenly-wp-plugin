declare const wp: any;
import { Component } from 'react';

const {
	Fragment
} = wp.element;

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