import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { Component } from 'react';

declare const wp: any;
declare const window: any;

const { __ } = wp.i18n;

const {
	Button,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

interface TokenMetaEditPageData {
	//
}

interface TokenMetaEditPageProps {
	pageData: TokenMetaEditPage;
	saving: boolean;
}

interface TokenMetaEditPageState {
	storingSource: boolean;
}

export default class TokenMetaEditPage extends Component<TokenMetaEditPageProps, TokenMetaEditPageState> {
	state: TokenMetaEditPageState = {
		storingSource: false,
	}
	constructor( props: TokenMetaEditPageProps ) {
		super( props );
	}

	render() {
		return (
			<div></div>
		);
	}
}
