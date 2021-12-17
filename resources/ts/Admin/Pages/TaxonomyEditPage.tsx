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

interface TaxonomyEditPageData {
	//
}

interface TaxonomyEditPageProps {
	pageData: TaxonomyEditPageData;
}

interface TaxonomyEditPageState {
	//
}

export default class TaxonomyEditPage extends Component<TaxonomyEditPageProps, TaxonomyEditPageState> {

	state: TaxonomyEditPageState = {
		//
	}
	
	constructor( props: TaxonomyEditPageProps ) {
		super( props );
	}

	render() {
		return (
			<Fragment>
			</Fragment>
		);
	}
}
