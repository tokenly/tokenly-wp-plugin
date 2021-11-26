import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';

import { 
	TextControl,
	TextareaControl,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface PostEditPageData {
	//
}

interface PostEditPageProps {
	pageData: PostEditPageData;
}

interface PostEditPageState {
	//
}

export default class PostEditPage extends Component<PostEditPageProps, PostEditPageState> {

	state: PostEditPageState = {
		//
	}
	
	constructor( props: PostEditPageProps ) {
		super( props );
	}

	render() {
		return (
			<Fragment>
			</Fragment>
		);
	}
}
